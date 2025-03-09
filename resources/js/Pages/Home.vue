<template>
  <AppLayout>
    <Container>
      <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-6">
          Bienvenue sur notre boutique
        </h1>
        
        <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
          Découvrez notre sélection de produits de qualité, 
          soigneusement choisis pour vous satisfaire.
        </p>

        <div class="space-y-4">
          <Link
            href="/products"
            class="btn-primary inline-block"
          >
            Découvrir nos produits
          </Link>

          <div v-if="!$page.props.auth.user" class="mt-4">
            <p class="text-gray-600 mb-4">Vous avez déjà un compte ?</p>
            <div class="space-x-4">
              <Link
                href="/login"
                class="btn-secondary inline-block"
              >
                Connexion
              </Link>
              <Link
                href="/register"
                class="btn-primary inline-block"
              >
                Inscription
              </Link>
            </div>
          </div>
        </div>

        <!-- Section des avantages -->
        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="p-6 bg-white rounded-lg shadow-sm">
            <div class="text-blue-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Qualité garantie</h3>
            <p class="text-gray-600">Des produits sélectionnés avec soin pour votre satisfaction.</p>
          </div>

          <div class="p-6 bg-white rounded-lg shadow-sm">
            <div class="text-blue-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Livraison rapide</h3>
            <p class="text-gray-600">Recevez vos commandes rapidement et en toute sécurité.</p>
          </div>

          <div class="p-6 bg-white rounded-lg shadow-sm">
            <div class="text-blue-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Service client</h3>
            <p class="text-gray-600">Une équipe à votre écoute pour vous accompagner.</p>
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
  }
});
</script> 