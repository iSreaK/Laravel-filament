<template>
  <AppLayout>
    <Container>
      <h1 class="section-title">Historique des commandes</h1>
      
      <div v-if="orders && orders.length" class="space-y-6">
        <div v-for="order in orders" :key="order.id" 
             class="card card-hover">
          <div class="flex flex-col sm:flex-row justify-between gap-4">
            <div class="space-y-2">
              <div class="flex items-center gap-3">
                <h3 class="text-lg font-medium text-gray-900">
                  Commande #{{ order.id }}
                </h3>
                <span :class="[
                  'badge',
                  order.status === 'completed' ? 'badge-success' : 'badge-primary'
                ]">
                  {{ order.status_label }}
                </span>
              </div>
              <p class="text-sm text-gray-600">
                Passée le {{ order.formatted_date }}
              </p>
              <p class="text-sm text-gray-600">
                {{ order.items_count }} article(s)
              </p>
              <div class="text-sm text-gray-600">
                <p>Livré à :</p>
                <p>{{ order.address.number }} {{ order.address.street }}</p>
                <p>{{ order.address.postal_code }} {{ order.address.city }}</p>
              </div>
            </div>
            
            <div class="flex items-center gap-4">
              <p class="text-xl font-bold text-green-600">{{ order.total }} €</p>
              <Link 
                :href="route('orders.show', order.id)"
                class="btn-primary flex items-center gap-2"
              >
                <span>Voir les détails</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
              </Link>
            </div>
          </div>
        </div>
      </div>
      
      <div v-else class="text-center py-12">
        <p class="text-gray-600 text-lg">
          {{ orders === null ? 'Chargement...' : 'Vous n\'avez pas encore passé de commande.' }}
        </p>
        <Link 
          :href="route('products.index')"
          class="btn-primary inline-block mt-4"
        >
          Découvrir nos produits
        </Link>
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
    orders: Array
  }
});
</script>