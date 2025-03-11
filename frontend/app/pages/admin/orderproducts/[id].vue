<template>
    <v-container fluid>
      <v-row>
        <AdminNav />
        <v-col class="v-col" cols="12" sm="8" md="9" lg="10">
          <v-card>
            <v-card-title class="d-flex align-center">
              <v-btn
                icon
                class="mr-2"
                @click="router.push('/admin/orders')"
              >
                <v-icon>mdi-arrow-left</v-icon>
              </v-btn>
              Détails de la Commande #{{ order.id }}
            </v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="12" md="6">
                  <v-card outlined>
                    <v-card-title>Informations de la Commande</v-card-title>
                    <v-card-text>
                      <v-row>
                        <v-col cols="6">
                          <div class="text-subtitle-2">Montant Total</div>
                          <v-text-field
                            v-if="isEditing"
                            v-model="order.totalAmount"
                            type="number"
                            dense
                            hide-details
                            class="edit-field"
                          ></v-text-field>
                          <div v-else>{{ order.totalAmount }}€</div>
                        </v-col>
                        <v-col cols="6">
                          <div class="text-subtitle-2">Statut</div>
                          <v-select
                            v-if="isEditing"
                            v-model="order.status"
                            :items="statusOptions"
                            dense
                            hide-details
                            class="edit-field"
                          ></v-select>
                          <div v-else>{{ order.status }}</div>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="6">
                          <div class="text-subtitle-2">Date</div>
                          <div>{{ order.date }}</div>
                        </v-col>
                        <v-col cols="6">
                          <div class="text-subtitle-2">Méthode de Paiement</div>
                          <v-text-field
                            v-if="isEditing"
                            v-model="order.paymentMethod"
                            dense
                            hide-details
                            class="edit-field"
                          ></v-text-field>
                          <div v-else>{{ order.paymentMethod }}</div>
                        </v-col>
                      </v-row>
                      <v-row>
                        <v-col cols="12">
                          <div class="text-subtitle-2">Adresse de Facturation</div>
                          <v-text-field
                            v-if="isEditing"
                            v-model="order.billingAddress"
                            dense
                            hide-details
                            class="edit-field"
                          ></v-text-field>
                          <div v-else>{{ order.billingAddress }}</div>
                        </v-col>
                      </v-row>
                    </v-card-text>
                  </v-card>
                </v-col>
                <v-col cols="12" md="6">
                  <v-card outlined>
                    <v-card-title class="d-flex align-center">
                      Produits de la Commande
                      <v-spacer></v-spacer>
                      <v-btn
                        v-if="isEditing"
                        color="primary"
                        size="small"
                        @click="openAddProductDialog"
                      >
                        <v-icon left>mdi-plus</v-icon>
                        Ajouter un produit
                      </v-btn>
                    </v-card-title>
                    <v-card-text>
                      <v-data-table
                        :headers="productHeaders"
                        :items="order.items"
                        :loading="loading"
                        class="elevation-1"
                      >
                        <template v-slot:item.quantity="{ item }">
                          <v-text-field
                            v-if="isEditing"
                            v-model="item.quantity"
                            type="number"
                            min="1"
                            dense
                            hide-details
                            class="edit-field"
                            @change="updateItemTotal(item)"
                          ></v-text-field>
                          <span v-else>{{ item.quantity }}</span>
                        </template>
                        <template v-slot:item.price="{ item }">
                          {{ item.price }}€
                        </template>
                        <template v-slot:item.actions="{ item }">
                          <v-btn
                            v-if="isEditing"
                            icon
                            color="error"
                            size="small"
                            @click="removeItem(item)"
                          >
                            <v-icon>mdi-delete</v-icon>
                          </v-btn>
                        </template>
                      </v-data-table>
                    </v-card-text>
                  </v-card>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-actions class="pa-4">
              <v-spacer></v-spacer>
              <v-btn
                v-if="isEditing"
                color="success"
                @click="saveOrder"
              >
                Sauvegarder
              </v-btn>
              <template v-else>
                <v-btn
                  color="primary"
                  class="mr-2"
                  @click="isEditing = true"
                >
                  Modifier
                </v-btn>
                <v-btn
                  color="error"
                  @click="confirmDelete"
                >
                  Supprimer
                </v-btn>
              </template>
            </v-card-actions>
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
  
      <!-- Boîte de dialogue d'ajout de produit -->
      <v-dialog
        v-model="addProductDialog"
        max-width="600"
        persistent
        :retain-focus="false"
      >
        <v-card>
          <v-card-title class="text-h5">
            Ajouter un produit
          </v-card-title>
          <v-card-text>
            <v-form ref="form" v-model="formValid">
              <v-select
                v-model="selectedProduct"
                :items="availableProducts"
                item-title="name"
                item-value="id"
                label="Sélectionner un produit"
                :rules="[v => !!v || 'Veuillez sélectionner un produit']"
                required
                return-object
              ></v-select>
              <v-text-field
                v-model="newProductQuantity"
                type="number"
                label="Quantité"
                min="1"
                :rules="[v => v > 0 || 'La quantité doit être supérieure à 0']"
                required
              ></v-text-field>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="grey"
              variant="text"
              @click="addProductDialog = false"
            >
              Annuler
            </v-btn>
            <v-btn
              color="primary"
              variant="text"
              :disabled="!formValid"
              @click="addProduct"
            >
              Ajouter
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>
  </template>
  
  <script setup>
  import AdminNav from '~/components/AdminNav.vue';
  import { ref, onMounted } from 'vue';
  import { useRouter, useRoute } from 'vue-router';
  
  definePageMeta({
    middleware: ['admin']
  });
  
  // Constantes
  const API_BASE_URL = 'http://localhost:8000/api';
  const API_KEY = 'd8aa3cc84418f09f1257c42cd8118a746cc2b7314310bc55f70562dd3e725c57';
  
  // États
  const loading = ref(false);
  const order = ref({});
  const isEditing = ref(false);
  const dialog = ref(false);
  const error = ref(null);
  const addProductDialog = ref(false);
  const selectedProduct = ref(null);
  const newProductQuantity = ref(1);
  const availableProducts = ref([]);
  const form = ref(null);
  const formValid = ref(false);
  
  // Options de statut
  const statusOptions = [
    'pending',
    'processing',
    'completed',
    'cancelled'
  ];
  
  // Headers de la table des produits
  const productHeaders = [
    { title: 'Produit', key: 'product.name' },
    { title: 'Quantité', key: 'quantity' },
    { title: 'Prix', key: 'price' },
    { title: 'Actions', key: 'actions' }
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
  const fetchOrder = async () => {
    try {
      loading.value = true;
      error.value = null;
      const route = useRoute();
      const response = await fetch(`${API_BASE_URL}/orders/${route.params.id}`, {
        headers: getAuthHeaders()
      });
      
      if (!response.ok) throw new Error('Erreur lors de la récupération de la commande');
      
      order.value = await response.json();
      if (!order.value.items) {
        order.value.items = [];
      }
    } catch (err) {
      handleError(err, 'Erreur lors de la récupération de la commande');
    } finally {
      loading.value = false;
    }
  };
  
  const saveOrder = async () => {
    try {
      error.value = null;
      const response = await fetch(`${API_BASE_URL}/orders/${order.value.id}`, {
        method: 'PUT',
        headers: getAuthHeaders(),
        body: JSON.stringify({
          totalAmount: order.value.totalAmount,
          status: order.value.status,
          paymentMethod: order.value.paymentMethod,
          billingAddress: order.value.billingAddress,
          items: order.value.items.map(item => ({
            id: item.id,
            quantity: item.quantity,
            productId: item.product.id
          }))
        })
      });
      
      if (!response.ok) throw new Error('Erreur lors de la modification de la commande');
      
      isEditing.value = false;
      await fetchOrder();
    } catch (err) {
      handleError(err, 'Erreur lors de la modification de la commande');
    }
  };
  
  const deleteOrder = async () => {
    try {
      error.value = null;
      const response = await fetch(`${API_BASE_URL}/orders/${order.value.id}`, {
        method: 'DELETE',
        headers: getAuthHeaders()
      });
      
      if (!response.ok) throw new Error('Erreur lors de la suppression de la commande');
      
      router.push('/admin/orders');
    } catch (err) {
      handleError(err, 'Erreur lors de la suppression de la commande');
    }
  };
  
  // Méthodes UI
  const confirmDelete = () => {
    dialog.value = true;
  };
  
  const router = useRouter();
  
  // Ajouter ces méthodes dans la section script
  const updateItemTotal = (item) => {
    item.price = item.product.price * item.quantity;
    updateOrderTotal();
  };
  
  const removeItem = (item) => {
    const index = order.value.items.indexOf(item);
    if (index > -1) {
      order.value.items.splice(index, 1);
      updateOrderTotal();
    }
  };
  
  const updateOrderTotal = () => {
    order.value.totalAmount = order.value.items.reduce((total, item) => total + item.price, 0);
  };
  
  const fetchAvailableProducts = async () => {
    try {
      const response = await fetch(`${API_BASE_URL}/public/products`, {
        headers: {
        'x-api-key': API_KEY
      }
      });
      if (!response.ok) throw new Error('Erreur lors de la récupération des produits');
      const data = await response.json();
      availableProducts.value = data.products;
    } catch (err) {
      console.error('Erreur complète:', err);
      handleError(err, 'Erreur lors de la récupération des produits');
    }
  };
  
  const openAddProductDialog = () => {
    addProductDialog.value = true;
    selectedProduct.value = null;
    newProductQuantity.value = 1;
    formValid.value = false;
    fetchAvailableProducts();
  };
  
  const addProduct = async () => {
    if (!form.value.validate()) return;

    if (!selectedProduct.value) return;

    const newItem = {
      id: Date.now(),
      product: {
        id: selectedProduct.value.id,
        name: selectedProduct.value.name,
        price: selectedProduct.value.price
      },
      quantity: parseInt(newProductQuantity.value),
      price: selectedProduct.value.price * parseInt(newProductQuantity.value)
    };

    if (!order.value.items) {
      order.value.items = [];
    }
    
    order.value.items.push(newItem);
    updateOrderTotal();
    addProductDialog.value = false;
    selectedProduct.value = null;
    newProductQuantity.value = 1;
  };
  
  onMounted(() => {
    fetchOrder();
    fetchAvailableProducts();
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
  
  /* Styles des boutons */
  .v-btn {
    font-family: 'Montserrat', sans-serif;
    text-transform: none;
    letter-spacing: 0.5px;
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
  
  .text-subtitle-2 {
    color: #000000;
    font-weight: 600;
  }
  
  .v-card-text div:not(.text-subtitle-2) {
    color: #000000;
    font-size: 1rem;
  }
  
  .v-data-table :deep(.v-data-table__wrapper) {
    color: #000000;
  }
  </style>`