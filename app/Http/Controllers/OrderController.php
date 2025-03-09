<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Item;
use App\Models\Address;
use App\Traits\FormatsDate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class OrderController extends Controller
{
    use FormatsDate;

    private array $paymentMethods = [
        ['id' => 'card', 'name' => 'Carte bancaire', 'description' => 'Paiement sécurisé par carte'],
        ['id' => 'paypal', 'name' => 'PayPal', 'description' => 'Paiement via votre compte PayPal']
    ];

    public function index(): Response
    {
        $orders = Order::with(['items.product', 'address'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
                // Gérer le cas où address est une chaîne de caractères (anciennes commandes)
                $addressData = is_string($order->address) 
                    ? [
                        'id' => null,
                        'number' => '',
                        'street' => $order->address, // L'ancienne adresse complète
                        'city' => '',
                        'postal_code' => '',
                        'country' => ''
                    ]
                    : ($order->address 
                        ? [
                            'id' => $order->address->id,
                            'number' => $order->address->number,
                            'street' => $order->address->street,
                            'city' => $order->address->city,
                            'postal_code' => $order->address->postal_code,
                            'country' => $order->address->country,
                        ]
                        : null);

                if (!$addressData) {
                    return null;
                }

                return [
                    'id' => $order->id,
                    'status' => $order->status,
                    'total' => $order->total,
                    'created_at' => $order->created_at,
                    'formatted_date' => $this->formatDate($order->created_at),
                    'items_count' => $order->items->sum('quantity'),
                    'status_label' => $order->status === 'completed' ? 'Complétée' : 'En cours',
                    'address' => $addressData
                ];
            })
            ->filter()
            ->values();

        return Inertia::render('Orders/Index', [
            'orders' => $orders
        ]);
    }

    public function show($id): Response
    {
        $order = Order::with(['items.product', 'address'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Gérer le cas où address est une chaîne de caractères
        $addressData = is_string($order->address)
            ? [
                'id' => null,
                'number' => '',
                'street' => $order->address,
                'city' => '',
                'postal_code' => '',
                'country' => ''
            ]
            : ($order->address
                ? $order->address->toArray()
                : null);

        return Inertia::render('Orders/Show', [
            'order' => [
                ...$order->toArray(),
                'address' => $addressData,
                'formatted_date' => $this->formatDate($order->created_at),
                'status_label' => $order->status === 'completed' ? 'Complétée' : 'En cours'
            ],
            'paymentMethods' => collect($this->paymentMethods)
                ->firstWhere('id', $order->payment_method)
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'address.number' => 'required|string',
            'address.street' => 'required|string',
            'address.postal_code' => 'required|string',
            'address.city' => 'required|string',
            'address.country' => 'required|string',
            'payment_method' => 'required|in:card,paypal'
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Le panier est vide.');
        }

        // Créer l'adresse
        $address = Address::create([
            'user_id' => auth()->id(),
            'number' => $validated['address']['number'],
            'street' => $validated['address']['street'],
            'postal_code' => $validated['address']['postal_code'],
            'city' => $validated['address']['city'],
            'country' => $validated['address']['country'],
        ]);

        // Créer la commande
        $order = Order::create([
            'user_id' => auth()->id(),
            'address_id' => $address->id,
            'total' => $this->calculateTotal($cart),
            'status' => 'pending',
            'payment_method' => $validated['payment_method']
        ]);

        foreach ($cart as $item) {
            Item::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        session()->forget('cart');

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Commande créée avec succès !');
    }

    public function create(): Response
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Votre panier est vide');
        }

        $cartItems = collect($cart)->map(function ($item) {
            return [
                ...$item,
                'subtotal' => $item['price'] * $item['quantity']
            ];
        })->values();

        // Assurez-vous que l'utilisateur a au moins une adresse
        $user = auth()->user();
        $addresses = $user->addresses;

        if ($addresses->isEmpty()) {
            return redirect()->route('addresses.index')
                ->with('error', 'Veuillez ajouter au moins une adresse de livraison');
        }

        return Inertia::render('Orders/Create', [
            'addresses' => $addresses->map(function ($address) {
                return [
                    ...$address->toArray(),
                    'full_address' => $address->full_address,
                    'display_name' => $address->name ?: "Adresse {$address->id}"
                ];
            }),
            'defaultAddress' => $user->defaultAddress,
            'paymentMethods' => $this->paymentMethods,
            'cart' => $cartItems,
            'total' => $cartItems->sum('subtotal')
        ]);
    }

    private function calculateTotal(array $cart): float
    {
        return array_reduce($cart, function ($total, $item) {
            return $total + ($item['price'] * $item['quantity']);
        }, 0);
    }
} 