<template>
  <AppLayout>
    <Container>
      <div class="space-y-8">
        <!-- En-tête avec filtres de catégories -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
          <h1 class="section-title mb-0 pb-0 border-0">Nos Produits</h1>
          
          <div class="flex flex-wrap gap-2">
            <Link 
              :href="route('products.index')"
              :class="[
                'px-4 py-2 rounded-full text-sm font-medium transition-colors',
                !selectedCategory 
                  ? 'bg-blue-600 text-white' 
                  : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
              ]"
            >
              Tous
            </Link>
            <Link 
              v-for="category in categories" 
              :key="category.id"
              :href="route('categories.products', category.id)"
              :class="[
                'px-4 py-2 rounded-full text-sm font-medium transition-colors',
                selectedCategory === category.id 
                  ? 'bg-blue-600 text-white' 
                  : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
              ]"
            >
              {{ category.name }}
            </Link>
          </div>
        </div>

        <!-- Grille de produits -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="product in products" 
               :key="product.id" 
               class="card card-hover flex flex-col">
            <div class="aspect-w-16 aspect-h-9 -mx-6 -mt-6 mb-4">
              <img 
                v-if="product.cover_image" 
                :src="product.cover_image.image"
                :alt="product.cover_image.alt_text"
                class="w-full h-48 object-cover rounded-t-xl"
              />
              <div v-else class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-t-xl">
                <span class="text-gray-400">Aucune image</span>
              </div>
            </div>
            
            <div class="space-y-4 flex-grow flex flex-col">
              <div class="flex-grow">
                <div class="flex flex-wrap gap-2 mb-2">
                  <span 
                    v-for="category in product.categories" 
                    :key="category.id"
                    class="badge badge-primary"
                  >
                    {{ category.name }}
                  </span>
                </div>
                <h2 class="text-xl font-semibold text-gray-900">{{ product.name }}</h2>
                <p class="text-2xl font-bold text-green-600">{{ product.price }} €</p>
              </div>
              <Link 
                :href="route('products.show', product.id)"
                class="btn-primary w-full mt-auto"
              >
                Voir le détail
              </Link>
            </div>
          </div>
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
    products: Array,
    categories: Array,
    selectedCategory: Object
  }
});
</script>