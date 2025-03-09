<template>
  <AppLayout>
    <Container>
      <div class="min-h-screen bg-gray-50">
        <div class="container mx-auto px-4 py-8">
          <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm p-8">
            <div class="mb-6">
              <img 
                v-if="product.cover_image" 
                :src="product.cover_image.image"
                :alt="product.cover_image.alt_text"
                class="w-full h-64 object-cover rounded-lg"
              />
              <div v-else class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                <span class="text-gray-400">Aucune image disponible</span>
              </div>
            </div>

            <div class="flex flex-wrap gap-2 mb-4">
              <span 
                v-for="category in product.categories" 
                :key="category.id"
                class="badge badge-primary"
              >
                {{ category.name }}
              </span>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ product.name }}</h1>
            
            <div class="space-y-6">
              <div class="flex items-center justify-between">
                <span class="text-3xl font-bold text-green-600">{{ product.price }} €</span>
                <button @click="addToCart" 
                        class="btn-primary flex items-center space-x-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                  <span>Ajouter au panier</span>
                </button>
              </div>
              
              <div class="border-t border-gray-200 pt-6">
                <p class="text-gray-700 leading-relaxed">{{ product.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Container>
  </AppLayout>
</template>

<script>
import { defineComponent } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';

export default defineComponent({
  components: {
    AppLayout,
    Container
  },
  props: {
    product: Object
  },
  setup(props) {
    const addToCart = () => {
      router.post(`/cart/add/${props.product.id}`);
    };
    return { addToCart };
  }
});
</script>