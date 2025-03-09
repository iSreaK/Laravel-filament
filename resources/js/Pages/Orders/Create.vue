<template>
  <AppLayout>
    <Container>
      <div class="space-y-8">
        <h1 class="section-title">Finaliser la commande</h1>

        <form @submit.prevent="submit" class="space-y-8">
          <!-- Saisie de l'adresse -->
          <div class="card">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">
              Adresse de livraison 
              <span class="text-red-500">*</span>
            </h2>

            <div class="space-y-4">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Numéro
                    <span class="text-red-500">*</span>
                  </label>
                  <input 
                    type="text" 
                    v-model="form.address.number"
                    class="form-input w-full"
                    required
                  />
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Rue
                    <span class="text-red-500">*</span>
                  </label>
                  <input 
                    type="text" 
                    v-model="form.address.street"
                    class="form-input w-full"
                    required
                  />
                </div>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Code postal
                    <span class="text-red-500">*</span>
                  </label>
                  <input 
                    type="text" 
                    v-model="form.address.postal_code"
                    class="form-input w-full"
                    required
                  />
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Ville
                    <span class="text-red-500">*</span>
                  </label>
                  <input 
                    type="text" 
                    v-model="form.address.city"
                    class="form-input w-full"
                    required
                  />
                </div>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Pays
                    <span class="text-red-500">*</span>
                  </label>
                  <input 
                    type="text" 
                    v-model="form.address.country"
                    class="form-input w-full"
                    required
                  />
                </div>
              </div>
            </div>
          </div>

          <!-- Méthode de paiement -->
          <div class="card">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Méthode de paiement</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div v-for="method in paymentMethods" 
                   :key="method.id"
                   :class="[
                     'p-4 rounded-lg border-2 cursor-pointer',
                     form.payment_method === method.id 
                       ? 'border-blue-500 bg-blue-50' 
                       : 'border-gray-200 hover:border-blue-200'
                   ]"
                   @click="form.payment_method = method.id">
                <p class="font-medium text-gray-900">{{ method.name }}</p>
                <p class="text-sm text-gray-600">{{ method.description }}</p>
              </div>
            </div>
          </div>

          <!-- Boutons -->
          <div class="flex justify-between">
            <Link 
              :href="route('cart.show')"
              class="btn-secondary"
            >
              Retour au panier
            </Link>
            <button 
              type="submit"
              class="btn-success"
            >
              Confirmer la commande
            </button>
          </div>
        </form>
      </div>
    </Container>
  </AppLayout>
</template>

<script>
import { defineComponent, ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';

export default defineComponent({
  components: {
    AppLayout,
    Container,
    Link
  },

  props: {
    paymentMethods: Array,
    cart: Array,
    total: Number
  },

  setup() {
    const form = ref({
      address: {
        number: '',
        street: '',
        postal_code: '',
        city: '',
        country: 'France'
      },
      payment_method: 'card'
    });

    const submit = () => {
      router.post(route('orders.store'), form.value);
    };

    return { form, submit };
  }
});
</script>