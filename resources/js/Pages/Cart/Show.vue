<template>
  <AppLayout>
    <Container>
      <h1 class="section-title">Votre panier</h1>
      
      <div v-if="cart && cart.length > 0" class="space-y-6">
        <div v-for="item in cart" :key="item.id" 
             class="card card-hover">
          <div class="flex items-center justify-between">
            <div class="flex-1">
              <h3 class="text-lg font-medium text-gray-900">{{ item.name }}</h3>
              <div class="mt-3 flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                  <label for="quantity" class="text-sm text-gray-600">Quantité :</label>
                  <div class="flex items-center border border-gray-300 rounded-lg">
                    <button 
                      @click="updateQuantity(item.id, Math.max(1, item.quantity - 1))"
                      class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-l-lg border-r"
                    >
                      -
                    </button>
                    <input
                      type="number"
                      v-model.number="item.quantity"
                      min="1"
                      @change="updateQuantity(item.id, item.quantity)"
                      class="w-16 text-center border-none focus:ring-0"
                    />
                    <button 
                      @click="updateQuantity(item.id, item.quantity + 1)"
                      class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-r-lg border-l"
                    >
                      +
                    </button>
                  </div>
                </div>
                <span class="text-sm font-medium text-gray-900">{{ item.price }} € / unité</span>
              </div>
            </div>
            
            <div class="flex items-center space-x-4">
              <p class="text-lg font-bold text-gray-900">{{ item.price * item.quantity }} €</p>
              <button @click="removeFromCart(item.id)" class="btn-danger">
                Retirer
              </button>
            </div>
          </div>
        </div>

        <div class="section">
          <div class="flex justify-between items-center">
            <p class="text-xl font-bold text-gray-900">Total</p>
            <p class="text-2xl font-bold text-green-600">{{ cartTotal }} €</p>
          </div>
          
          <button @click="checkout" class="btn-success w-full mt-6">
            Passer commande
          </button>
        </div>
      </div>
      
      <div v-else class="text-center py-12">
        <p class="text-gray-600 text-lg">Votre panier est vide.</p>
        <a href="/products" class="btn-primary inline-block mt-4">
          Découvrir nos produits
        </a>
      </div>
    </Container>
  </AppLayout>
</template>

<script>
import { defineComponent, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';

export default defineComponent({
  components: {
    AppLayout,
    Container
  },
  props: {
    cart: {
      type: Array,
      default: () => []
    }
  },
  setup(props) {
    const cartTotal = computed(() => {
      return props.cart.reduce((total, item) => {
        return total + (item.price * item.quantity);
      }, 0);
    });

    const updateQuantity = (id, quantity) => {
      if (quantity < 1) return;
      router.post(`/cart/update/${id}`, {
        quantity: quantity
      });
    };

    const removeFromCart = (id) => {
      router.post(`/cart/remove/${id}`);
    };

    const checkout = () => {
      router.get('/orders/create');
    };

    return { 
      removeFromCart, 
      checkout, 
      cartTotal,
      updateQuantity
    };
  }
});
</script>