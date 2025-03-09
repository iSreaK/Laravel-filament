<template>
  <AppLayout>
    <Container>
      <div class="space-y-8">
        <div class="flex justify-between items-center">
          <h1 class="section-title">Commande #{{ order.id }}</h1>
          <span :class="[
            'badge',
            order.status === 'completed' ? 'badge-success' : 'badge-primary'
          ]">
            {{ order.status === 'completed' ? 'Complétée' : 'En cours' }}
          </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Informations de livraison -->
          <div class="card">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations de livraison</h2>
            <div class="space-y-2 text-gray-700">
              <p class="font-medium">Adresse de livraison :</p>
              <p>{{ order.address.name || `Adresse ${order.address.id}` }}</p>
              <p>{{ order.address.number }} {{ order.address.street }}</p>
              <p>{{ order.address.postal_code }} {{ order.address.city }}</p>
              <p>{{ order.address.country }}</p>
            </div>
          </div>

          <!-- Informations de paiement -->
          <div class="card">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informations de paiement</h2>
            <div class="space-y-2 text-gray-700">
              <p class="font-medium">Méthode de paiement :</p>
              <p>{{ paymentMethods.name }}</p>
              <p class="text-sm text-gray-500">{{ paymentMethods.description }}</p>
            </div>
          </div>
        </div>

        <!-- Récapitulatif des produits -->
        <div class="card">
          <h2 class="text-xl font-semibold text-gray-900 mb-4">Produits commandés</h2>
          <div class="space-y-4">
            <div v-for="item in order.items" 
                 :key="item.id" 
                 class="flex justify-between items-center py-4 border-b last:border-0">
              <div>
                <h3 class="font-medium text-gray-900">{{ item.product.name }}</h3>
                <p class="text-sm text-gray-600">Quantité : {{ item.quantity }}</p>
              </div>
              <p class="font-medium text-gray-900">{{ item.price * item.quantity }} €</p>
            </div>

            <div class="flex justify-between items-center pt-4 font-bold">
              <p class="text-lg text-gray-900">Total</p>
              <p class="text-xl text-green-600">{{ order.total }} €</p>
            </div>
          </div>
        </div>

        <div class="flex justify-start">
          <Link 
            :href="route('orders.index')"
            class="btn-primary"
          >
            Retour aux commandes
          </Link>
        </div>
      </div>
    </Container>
  </AppLayout>
</template>

<script>
import { defineComponent } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';

export default defineComponent({
  components: {
    AppLayout,
    Container,
    Link
  },
  props: {
    order: Object,
    paymentMethods: Object
  }
});
</script>