<template>
  <AppLayout>
    <Container>
      <div class="space-y-8">
        <div class="flex justify-between items-center">
          <h1 class="section-title">Mes adresses</h1>
          <button 
            @click="showAddForm = true"
            class="btn-primary"
          >
            Ajouter une adresse
          </button>
        </div>

        <!-- Liste des adresses -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div v-for="address in addresses" 
               :key="address.id" 
               class="card relative">
            <!-- Badge adresse par défaut -->
            <div v-if="address.is_default" 
                 class="absolute top-2 right-2">
              <span class="badge badge-success">Par défaut</span>
            </div>

            <!-- Nom de l'adresse -->
            <h3 class="text-lg font-medium text-gray-900 mb-2">
              {{ address.name || 'Adresse ' + address.id }}
            </h3>

            <!-- Détails de l'adresse -->
            <div class="text-gray-600 space-y-1 mb-4">
              <p>{{ address.number }} {{ address.street }}</p>
              <p>{{ address.postal_code }} {{ address.city }}</p>
              <p>{{ address.country }}</p>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3">
              <button 
                v-if="!address.is_default"
                @click="setDefault(address.id)"
                class="btn-secondary text-sm"
              >
                Définir par défaut
              </button>
              <button 
                @click="editAddress(address)"
                class="btn-primary text-sm"
              >
                Modifier
              </button>
              <button 
                @click="deleteAddress(address.id)"
                class="btn-danger text-sm"
              >
                Supprimer
              </button>
            </div>
          </div>
        </div>

        <!-- Message si aucune adresse -->
        <div v-if="!addresses.length" class="text-center py-12 bg-gray-50 rounded-lg">
          <p class="text-gray-600">Vous n'avez pas encore ajouté d'adresse.</p>
        </div>

        <!-- Modal Ajout/Modification d'adresse -->
        <Modal :show="showAddForm" @close="closeModal">
          <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-6">
              {{ editingAddress ? 'Modifier l\'adresse' : 'Ajouter une adresse' }}
            </h2>

            <form @submit.prevent="submitForm" class="space-y-4">
              <!-- Nom de l'adresse -->
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nom de l'adresse (optionnel)</label>
                <input 
                  type="text"
                  id="name"
                  v-model="form.name"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                  placeholder="ex: Domicile, Bureau..."
                />
              </div>

              <!-- Rue -->
              <div>
                <label for="street" class="block text-sm font-medium text-gray-700">Rue</label>
                <input 
                  type="text"
                  id="street"
                  v-model="form.street"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                  required
                />
              </div>

              <!-- Numéro -->
              <div>
                <label for="number" class="block text-sm font-medium text-gray-700">Numéro</label>
                <input 
                  type="text"
                  id="number"
                  v-model="form.number"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                  required
                />
              </div>

              <!-- Code postal -->
              <div>
                <label for="postal_code" class="block text-sm font-medium text-gray-700">Code postal</label>
                <input 
                  type="text"
                  id="postal_code"
                  v-model="form.postal_code"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                  required
                />
              </div>

              <!-- Ville -->
              <div>
                <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
                <input 
                  type="text"
                  id="city"
                  v-model="form.city"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                  required
                />
              </div>

              <!-- Pays -->
              <div>
                <label for="country" class="block text-sm font-medium text-gray-700">Pays</label>
                <input 
                  type="text"
                  id="country"
                  v-model="form.country"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                  required
                />
              </div>

              <!-- Adresse par défaut -->
              <div class="flex items-center">
                <input 
                  type="checkbox"
                  id="is_default"
                  v-model="form.is_default"
                  class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                />
                <label for="is_default" class="ml-2 block text-sm text-gray-900">
                  Définir comme adresse par défaut
                </label>
              </div>

              <!-- Boutons -->
              <div class="flex justify-end gap-3 mt-6">
                <button 
                  type="button"
                  @click="closeModal"
                  class="btn-secondary"
                >
                  Annuler
                </button>
                <button 
                  type="submit"
                  class="btn-primary"
                >
                  {{ editingAddress ? 'Modifier' : 'Ajouter' }}
                </button>
              </div>
            </form>
          </div>
        </Modal>
      </div>
    </Container>
  </AppLayout>
</template>

<script>
import { defineComponent, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';
import Modal from '@/Components/Modal.vue';

export default defineComponent({
  components: {
    AppLayout,
    Container,
    Modal
  },

  props: {
    addresses: {
      type: Array,
      default: () => []
    }
  },

  setup() {
    const showAddForm = ref(false);
    const editingAddress = ref(null);
    const form = ref({
      name: '',
      street: '',
      number: '',
      city: '',
      country: '',
      postal_code: '',
      is_default: false
    });

    const closeModal = () => {
      showAddForm.value = false;
      editingAddress.value = null;
      form.value = {
        name: '',
        street: '',
        number: '',
        city: '',
        country: '',
        postal_code: '',
        is_default: false
      };
    };

    const editAddress = (address) => {
      editingAddress.value = address;
      form.value = { ...address };
      showAddForm.value = true;
    };

    const submitForm = () => {
      if (editingAddress.value) {
        router.put(`/addresses/${editingAddress.value.id}`, form.value, {
          onSuccess: () => closeModal()
        });
      } else {
        router.post('/addresses', form.value, {
          onSuccess: () => closeModal()
        });
      }
    };

    const deleteAddress = (id) => {
      if (confirm('Êtes-vous sûr de vouloir supprimer cette adresse ?')) {
        router.delete(`/addresses/${id}`);
      }
    };

    const setDefault = (id) => {
      router.post(`/addresses/${id}/default`);
    };

    return {
      showAddForm,
      editingAddress,
      form,
      closeModal,
      editAddress,
      submitForm,
      deleteAddress,
      setDefault
    };
  }
});
</script> 