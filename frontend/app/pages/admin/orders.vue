<template>
  <v-container fluid>
    <v-row>
      <AdminNav />
      <v-col class="v-col" cols="12" sm="8" md="9" lg="10">
        <v-card>
          <v-card-title>Commandes</v-card-title>
          <v-card-text>
            <v-text-field
              v-model="searchId"
              label="Rechercher par ID"
              prepend-icon="mdi-magnify"
              clearable
              class="mb-4 search-field"
              style="max-width: 300px;"
              variant="outlined"
              density="comfortable"
            ></v-text-field>
            <v-data-table
              :headers="headers"
              :items="filteredOrders"
              :loading="loading"
              class="elevation-1"
            >
              <template v-slot:item="{ item }">
                <tr>
                  <td>{{ item.id }}</td>
                  <td>
                    <v-text-field
                      v-if="item.isEditing"
                      v-model="item.totalAmount"
                      type="number"
                      dense
                      hide-details
                      class="edit-field"
                      style="width: 120px;"
                    ></v-text-field>
                    <span v-else>{{ item.totalAmount }}€</span>
                  </td>
                  <td>
                    <v-select
                      v-if="item.isEditing"
                      v-model="item.status"
                      :items="statusOptions"
                      dense
                      hide-details
                      class="edit-field"
                      style="width: 150px;"
                    ></v-select>
                    <span v-else>{{ item.status }}</span>
                  </td>
                  <td>
                    <span>{{ item.date }}</span>
                  </td>
                  <td>
                    <v-text-field
                      v-if="item.isEditing"
                      v-model="item.paymentMethod"
                      dense
                      hide-details
                      class="edit-field"
                      style="width: 150px;"
                    ></v-text-field>
                    <span v-else>{{ item.paymentMethod }}</span>
                  </td>
                  <td>
                    <v-text-field
                      v-if="item.isEditing"
                      v-model="item.billingAddress"
                      dense
                      hide-details
                      class="edit-field"
                      style="width: 200px;"
                    ></v-text-field>
                    <span v-else>{{ item.billingAddress }}</span>
                  </td>
                  <td>
                    <div class="d-flex gap-2">
                      <v-btn
                        v-if="item.isEditing"
                        color="success"
                        small
                        @click="saveOrder(item)"
                      >
                        Sauvegarder
                      </v-btn>
                      <template v-else>
                        <v-btn
                          color="info"
                          small
                          @click="viewOrderProducts(item)"
                        >
                          Consulter
                        </v-btn>
                        <v-btn
                          color="primary"
                          small
                          @click="editOrder(item)"
                        >
                          Modifier
                        </v-btn>
                        <v-btn
                          color="error"
                          small
                          @click="confirmDelete(item)"
                        >
                          Supprimer
                        </v-btn>
                      </template>
                    </div>
                  </td>
                </tr>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Boîte de dialogue de confirmation -->
    <v-dialog v-model="dialog" max-width="400">
      <v-card>
        <v-card-title>Confirmer la suppression</v-card-title>
        <v-card-text>
          Êtes-vous sûr de vouloir supprimer cette commande ?
          Cette action est irréversible.
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey" text @click="dialog = false">Annuler</v-btn>
          <v-btn color="error" text @click="deleteOrder">Supprimer</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script setup>
import AdminNav from '~/components/AdminNav.vue';
import { ref, onMounted, computed } from 'vue';
import { useRouter } from 'vue-router';

definePageMeta({
  middleware: ['admin']
});

// Constantes
const API_BASE_URL = 'http://localhost:8000/api';

// États
const loading = ref(false);
const orders = ref([]);
const dialog = ref(false);
const orderToDelete = ref(null);
const error = ref(null);
const searchId = ref('');

// Computed property pour filtrer les commandes
const filteredOrders = computed(() => {
  if (!searchId.value) return orders.value;
  return orders.value.filter(order => 
    order.id.toString().includes(searchId.value)
  );
});

// Options de statut
const statusOptions = [
  'pending',
  'processing',
  'completed',
  'cancelled'
];

// Headers de la table
const headers = [
  { title: 'ID', key: 'id', width: '80px' },
  { title: 'Montant Total', key: 'totalAmount', width: '120px' },
  { title: 'Statut', key: 'status', width: '150px' },
  { title: 'Date', key: 'date', width: '180px' },
  { title: 'Méthode de Paiement', key: 'paymentMethod', width: '150px' },
  { title: 'Adresse de Facturation', key: 'billingAddress', width: '200px' },
  { title: 'Actions', key: 'actions', width: '150px' }
];

// Méthodes utilitaires
const getAuthHeaders = () => ({
  'Content-Type': 'application/json',
  'Authorization': `Bearer ${localStorage.getItem('token')}`
});

const handleError = (error, message) => {
  console.error(message, error);
  error.value = message;
};

// Méthodes CRUD
const fetchOrders = async () => {
  try {
    loading.value = true;
    error.value = null;
    const response = await fetch(`${API_BASE_URL}/orders`, {
      headers: getAuthHeaders()
    });
    
    if (!response.ok) throw new Error('Erreur lors de la récupération des commandes');
    
    const data = await response.json();
    orders.value = data.map(order => ({
      ...order,
      isEditing: false
    }));
  } catch (err) {
    handleError(err, 'Erreur lors de la récupération des commandes');
  } finally {
    loading.value = false;
  }
};

const saveOrder = async (order) => {
  try {
    error.value = null;
    const response = await fetch(`${API_BASE_URL}/orders/${order.id}`, {
      method: 'PUT',
      headers: getAuthHeaders(),
      body: JSON.stringify({
        totalAmount: order.totalAmount,
        status: order.status,
        paymentMethod: order.paymentMethod,
        billingAddress: order.billingAddress
      })
    });
    
    if (!response.ok) throw new Error('Erreur lors de la modification de la commande');
    
    order.isEditing = false;
    await fetchOrders();
  } catch (err) {
    handleError(err, 'Erreur lors de la modification de la commande');
  }
};

const deleteOrder = async () => {
  try {
    error.value = null;
    const response = await fetch(`${API_BASE_URL}/orders/${orderToDelete.value.id}`, {
      method: 'DELETE',
      headers: getAuthHeaders()
    });
    
    if (!response.ok) throw new Error('Erreur lors de la suppression de la commande');
    
    orders.value = orders.value.filter(order => order.id !== orderToDelete.value.id);
    dialog.value = false;
    orderToDelete.value = null;
  } catch (err) {
    handleError(err, 'Erreur lors de la suppression de la commande');
  }
};

// Méthodes UI
const editOrder = (order) => {
  order.isEditing = true;
};

const confirmDelete = (order) => {
  orderToDelete.value = order;
  dialog.value = true;
};

const router = useRouter();

const viewOrderProducts = (order) => {
  router.push(`/admin/orderproducts/${order.id}`);
};

onMounted(() => {
  fetchOrders();
});
</script>

<style scoped>
/* Variables CSS */
:root {
  --primary-color: #000000;
  --secondary-color: rgba(0, 0, 0, 0.1);
  --hover-color: rgba(0, 0, 0, 0.02);
  --shadow-color: rgba(0, 0, 0, 0.05);
  --hover-shadow-color: rgba(0, 0, 0, 0.1);
}


.search-field :deep(.v-field__outline) {
  border-color: rgba(0, 0, 0, 0.1);;
}

.search-field :deep(.v-field__input),
.search-field :deep(.v-label),
.search-field :deep(.v-field-label),
.search-field :deep(.v-icon) {
  color: #000000 !important;
}

/* Styles de base */
.v-container {
  min-height: 100vh;
  background: #ffffff;
  padding: 50px 20px;
  margin-top: 60px;
  position: relative;
}

.v-card-title {
  color: #000000 !important;
}

.v-card {
  background: #ffffff;
  border: 1px solid var(--secondary-color);
  transition: all 0.4s ease;
  border-radius: 8px;
  box-shadow: 0 4px 20px var(--shadow-color);
}

.v-card:hover {
  box-shadow: 0 8px 30px var(--hover-shadow-color);
}

/* Styles de la table */
.v-data-table {
  font-family: 'Montserrat', sans-serif;
  background-color: #ffffff;
  color: #000000 !important;
}

.v-data-table :deep(th) {
  font-weight: 600;
  color: #000000 !important;
  background-color: #ffffff;
  white-space: nowrap;
}

.v-data-table :deep(td) {
  padding: 12px 16px;
  color: #000000 !important;
  background-color: #ffffff;
  white-space: nowrap;
}

.v-data-table :deep(.v-data-table__wrapper) {
  color: #000000 !important;
}

.v-data-table :deep(.v-data-table__wrapper table) {
  color: #000000 !important;
}

/* Styles des boutons */
.v-btn {
  font-family: 'Montserrat', sans-serif;
  text-transform: none;
  letter-spacing: 0.5px;
}

/* Media queries */
@media (max-width: 960px) {
  .v-container {
    padding: 30px 15px;
    margin-top: 40px;
  }

  .v-card-title {
    font-size: 1.8rem;
    padding: 15px;
  }

  .v-data-table {
    overflow-x: auto;
  }

  .v-data-table :deep(th),
  .v-data-table :deep(td) {
    padding: 8px 12px;
    font-size: 0.9rem;
  }
}

@media (max-width: 600px) {
  .v-container {
    padding: 20px 10px;
    margin-top: 30px;
  }

  .v-card-title {
    font-size: 1.5rem;
    padding: 12px;
  }

  .v-data-table :deep(th),
  .v-data-table :deep(td) {
    padding: 6px 8px;
    font-size: 0.85rem;
  }

  .v-btn {
    padding: 4px 8px;
    font-size: 0.8rem;
  }
}

/* Styles d'impression */
@media print {
  .v-container {
    margin: 0;
    padding: 0;
  }

  .v-card {
    box-shadow: none !important;
    border: none !important;
  }

  .v-card-title {
    border-bottom: none;
  }
}

/* Styles utilitaires */
.gap-2 {
  gap: 8px;
}

/* Styles de la boîte de dialogue */
.v-dialog :deep(.v-card-title),
.v-dialog :deep(.v-label),
.v-dialog :deep(.v-field__input),
.v-dialog :deep(.v-select__selection-text),
.v-dialog :deep(.v-card-text),
.v-dialog :deep(.v-card-title),
.v-dialog :deep(.v-btn__content) {
  color: #000000 !important;
}

.v-dialog :deep(.v-field__outline) {
  color: rgba(0, 0, 0, 0.38);
}

.v-dialog :deep(.v-field--focused .v-field__outline) {
  color: #000000 !important;
}

.v-dialog :deep(.v-select__selection) {
  color: #000000 !important;
}

.v-dialog :deep(.v-select__slot) {
  color: #000000 !important;
}

.v-dialog :deep(.v-select__slot input) {
  color: #000000 !important;
}

/* Styles pour les champs d'édition */
.edit-field {
  background-color: #f5f5f5;
  border-radius: 4px;
  padding: 4px 8px;
}

.edit-field :deep(.v-field__input) {
  min-height: 32px;
  padding: 4px 8px;
}

.edit-field :deep(.v-field__outline) {
  border-color: #e0e0e0;
}

.edit-field :deep(.v-field--focused .v-field__outline) {
  border-color: #000000;
}
</style>
