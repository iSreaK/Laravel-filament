<template>
  <nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <!-- Logo et liens principaux -->
        <div class="flex">
          <div class="flex-shrink-0 flex items-center">
            <Link href="/" class="text-xl font-bold text-gray-800">
              MonSite
            </Link>
          </div>
          <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
            <Link 
              href="/products"
              class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 
                     border-b-2 border-transparent hover:border-gray-300"
            >
              Produits
            </Link>
          </div>
        </div>

        <!-- Boutons de droite -->
        <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
          <!-- Panier avec compteur -->
          <Link 
            href="/cart"
            class="relative p-2 text-gray-600 hover:text-gray-900"
          >
            <span class="sr-only">Panier</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span v-if="cartItemsCount > 0" 
                  class="absolute top-0 right-0 -mt-1 -mr-1 px-2 py-1 text-xs font-bold 
                         text-white bg-red-500 rounded-full">
              {{ cartItemsCount }}
            </span>
          </Link>

          <!-- Menu utilisateur -->
          <template v-if="$page.props.auth.user">
            <div class="relative ml-3">
              <div>
                <button
                  @click="isUserMenuOpen = !isUserMenuOpen"
                  class="flex text-sm rounded-full focus:outline-none focus:ring-2 
                         focus:ring-offset-2 focus:ring-blue-500"
                >
                  <span class="sr-only">Ouvrir le menu utilisateur</span>
                  <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                    <span class="text-sm font-medium text-gray-700">
                      {{ $page.props.auth.user.name.charAt(0) }}
                    </span>
                  </div>
                </button>
              </div>
              
              <!-- Menu déroulant -->
              <div v-if="isUserMenuOpen"
                   class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg 
                          py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
              >
                <Link
                  href="/orders"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                  Mes commandes
                </Link>
                <form @submit.prevent="logout" class="block">
                  <button
                    type="submit"
                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                  >
                    Déconnexion
                  </button>
                </form>
              </div>
            </div>
          </template>
          
          <!-- Liens de connexion/inscription -->
          <template v-else>
            <Link
              href="/login"
              class="text-sm font-medium text-gray-700 hover:text-gray-900"
            >
              Connexion
            </Link>
            <Link
              href="/register"
              class="text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 
                     px-4 py-2 rounded-md"
            >
              Inscription
            </Link>
          </template>
        </div>

        <!-- Menu mobile -->
        <div class="-mr-2 flex items-center sm:hidden">
          <button
            @click="isMobileMenuOpen = !isMobileMenuOpen"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 
                   hover:text-gray-500 hover:bg-gray-100 focus:outline-none 
                   focus:ring-2 focus:ring-inset focus:ring-blue-500"
          >
            <span class="sr-only">Ouvrir le menu principal</span>
            <svg
              class="h-6 w-6"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Menu mobile -->
    <div v-if="isMobileMenuOpen" class="sm:hidden">
      <div class="pt-2 pb-3 space-y-1">
        <Link
          href="/products"
          class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 
                 hover:text-gray-900 hover:bg-gray-50"
        >
          Produits
        </Link>
        <Link
          href="/cart"
          class="block pl-3 pr-4 py-2 text-base font-medium text-gray-700 
                 hover:text-gray-900 hover:bg-gray-50"
        >
          Panier
        </Link>
      </div>
      
      <div class="pt-4 pb-3 border-t border-gray-200">
        <template v-if="$page.props.auth.user">
          <div class="px-4">
            <div class="text-base font-medium text-gray-800">
              {{ $page.props.auth.user.name }}
            </div>
            <div class="text-sm font-medium text-gray-500">
              {{ $page.props.auth.user.email }}
            </div>
          </div>
          <div class="mt-3 space-y-1">
            <Link
              href="/orders"
              class="block px-4 py-2 text-base font-medium text-gray-700 
                     hover:text-gray-900 hover:bg-gray-50"
            >
              Mes commandes
            </Link>
            <form @submit.prevent="logout">
              <button
                type="submit"
                class="w-full text-left block px-4 py-2 text-base font-medium 
                       text-gray-700 hover:text-gray-900 hover:bg-gray-50"
              >
                Déconnexion
              </button>
            </form>
          </div>
        </template>
        <template v-else>
          <div class="space-y-1">
            <Link
              href="/login"
              class="block px-4 py-2 text-base font-medium text-gray-700 
                     hover:text-gray-900 hover:bg-gray-50"
            >
              Connexion
            </Link>
            <Link
              href="/register"
              class="block px-4 py-2 text-base font-medium text-gray-700 
                     hover:text-gray-900 hover:bg-gray-50"
            >
              Inscription
            </Link>
          </div>
        </template>
      </div>
    </div>
  </nav>
</template>

<script>
import { defineComponent, ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

export default defineComponent({
  components: {
    Link
  },
  
  setup() {
    const isUserMenuOpen = ref(false);
    const isMobileMenuOpen = ref(false);

    const cartItemsCount = computed(() => {
      const cart = JSON.parse(localStorage.getItem('cart') || '[]');
      return cart.length;
    });

    const logout = () => {
      router.post('/logout');
    };

    return {
      isUserMenuOpen,
      isMobileMenuOpen,
      cartItemsCount,
      logout
    };
  }
});
</script> 