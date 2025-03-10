<template>
  <v-container fluid>
    <v-row>
      <AdminNav />
      <v-col class="v-col" cols="12" sm="8" md="9" lg="10">
        <v-card>
          <v-card-title>Produits</v-card-title>
          <v-card-text>
            <v-data-table
              :headers="headers"
              :items="products"
              :loading="loading"
              class="elevation-1"
            >
              <template v-slot:item="{ item }">
                <tr>
                  <td>{{ item.id }}</td>
                  <td>
                    <v-text-field
                      v-if="item.isEditing"
                      v-model="item.name"
                      dense
                      hide-details
                      class="edit-field"
                      style="width: 180px;"
                    ></v-text-field>
                    <span v-else>{{ item.name }}</span>
                  </td>
                  <td>
                    <v-text-field
                      v-if="item.isEditing"
                      v-model="item.description"
                      dense
                      hide-details
                      class="edit-field"
                      style="width: 280px;"
                    ></v-text-field>
                    <span v-else>{{ item.description }}</span>
                  </td>
                  <td>
                    <v-text-field
                      v-if="item.isEditing"
                      v-model="item.price"
                      type="number"
                      dense
                      hide-details
                      class="edit-field"
                      style="width: 100px;"
                    ></v-text-field>
                    <span v-else>{{ item.price }}€</span>
                  </td>
                  <td>
                    <v-text-field
                      v-if="item.isEditing"
                      v-model="item.stock"
                      type="number"
                      dense
                      hide-details
                      class="edit-field"
                      style="width: 100px;"
                    ></v-text-field>
                    <span v-else>{{ item.stock }}</span>
                  </td>
                  <td>
                    <v-text-field
                      v-if="item.isEditing"
                      v-model="item.weight"
                      type="number"
                      dense
                      hide-details
                      class="edit-field"
                      style="width: 100px;"
                    ></v-text-field>
                    <span v-else>{{ item.weight }}g</span>
                  </td>
                  <td>
                    <v-text-field
                      v-if="item.isEditing"
                      v-model="item.ingredients"
                      dense
                      hide-details
                      class="edit-field"
                      style="width: 230px;"
                    ></v-text-field>
                    <span v-else>{{ item.ingredients }}</span>
                  </td>
                  <td>
                    <v-select
                      v-if="item.isEditing"
                      v-model="item.category_id"
                      :items="categories"
                      item-title="name"
                      item-value="id"
                      dense
                      hide-details
                      class="edit-field"
                      style="width: 130px;"
                      :rules="[v => !!v || 'La catégorie est requise']"
                    ></v-select>
                    <span v-else>{{ item.category?.name }}</span>
                  </td>
                  <td>
                    <v-img
                      v-if="item.imageUrl"
                      :src="item.imageUrl"
                      max-width="50"
                      max-height="50"
                      cover
                    ></v-img>
                    <v-file-input
                      v-if="item.isEditing"
                      v-model="item.newImage"
                      accept="image/*"
                      prepend-icon="mdi-camera"
                      dense
                      hide-details
                      class="edit-field"
                      style="width: 200px;"
                    ></v-file-input>
                  </td>
                  <td>
                    <div class="d-flex gap-2">
                      <v-btn
                        v-if="item.isEditing"
                        color="success"
                        small
                        @click="saveProduct(item)"
                      >
                        Sauvegarder
                      </v-btn>
                      <template v-else>
                        <v-btn
                          color="primary"
                          small
                          @click="editProduct(item)"
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
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="openCreateDialog">
              <v-icon left>mdi-plus</v-icon>
              Nouveau produit
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>

    <!-- Boîte de dialogue de création -->
    <v-dialog v-model="createDialog" max-width="600">
      <v-card>
        <v-card-title>Créer un nouveau produit</v-card-title>
        <v-card-text>
          <v-form ref="form" v-model="valid">
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="newProduct.name"
                  label="Nom"
                  :rules="[v => !!v || 'Le nom est requis']"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-textarea
                  v-model="newProduct.description"
                  label="Description"
                  :rules="[v => !!v || 'La description est requise']"
                ></v-textarea>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="newProduct.price"
                  label="Prix"
                  type="number"
                  :rules="[v => !!v || 'Le prix est requis']"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="newProduct.stock"
                  label="Stock"
                  type="number"
                  :rules="[v => !!v || 'Le stock est requis']"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="newProduct.weight"
                  label="Poids (en grammes)"
                  type="number"
                  :rules="[v => !!v || 'Le poids est requis']"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  v-model="newProduct.ingredients"
                  label="Ingrédients"
                  :rules="[v => !!v || 'Les ingrédients sont requis']"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-select
                  v-model="newProduct.category_id"
                  :items="categories"
                  item-title="name"
                  item-value="id"
                  label="Catégorie"
                  :rules="[v => !!v || 'La catégorie est requise']"
                  :disabled="categories.length === 0"
                  :hint="categories.length === 0 ? 'Aucune catégorie disponible' : ''"
                  persistent-hint
                ></v-select>
              </v-col>
              <v-col cols="12">
                <v-file-input
                  v-model="newProduct.image"
                  label="Image"
                  accept="image/*"
                  prepend-icon="mdi-camera"
                ></v-file-input>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey" text @click="createDialog = false">Annuler</v-btn>
          <v-btn color="primary" text @click="createProduct" :disabled="!valid">Créer</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Boîte de dialogue de confirmation -->
    <v-dialog v-model="dialog" max-width="400">
      <v-card>
        <v-card-title>Confirmer la suppression</v-card-title>
        <v-card-text>
          Êtes-vous sûr de vouloir supprimer ce produit ?
          Cette action est irréversible.
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="grey" text @click="dialog = false">Annuler</v-btn>
          <v-btn color="error" text @click="deleteProduct">Supprimer</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script setup>
import AdminNav from '~/components/AdminNav.vue';
import { ref, onMounted } from 'vue';

definePageMeta({
  middleware: ['admin']
});

// Constantes
const API_BASE_URL = 'http://localhost:8000/api';
const DEFAULT_PRODUCT = {
  name: '',
  description: '',
  price: '',
  stock: '',
  weight: '',
  ingredients: '',
  category_id: null,
  image: null
};

// États
const loading = ref(false);
const products = ref([]);
const categories = ref([]);
const dialog = ref(false);
const productToDelete = ref(null);
const createDialog = ref(false);
const valid = ref(false);
const form = ref(null);
const error = ref(null);

// Headers de la table
const headers = [
  { title: 'ID', key: 'id', width: '80px' },
  { title: 'Nom', key: 'name', width: '200px' },
  { title: 'Description', key: 'description', width: '300px' },
  { title: 'Prix', key: 'price', width: '120px' },
  { title: 'Stock', key: 'stock', width: '120px' },
  { title: 'Poids', key: 'weight', width: '120px' },
  { title: 'Ingrédients', key: 'ingredients', width: '250px' },
  { title: 'Catégorie', key: 'category', width: '150px' },
  { title: 'Image', key: 'image', width: '100px' },
  { title: 'Actions', key: 'actions', width: '150px' }
];

const newProduct = ref({ ...DEFAULT_PRODUCT });

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
const fetchProducts = async () => {
  try {
    loading.value = true;
    error.value = null;
    const response = await fetch(`${API_BASE_URL}/products`, {
      headers: getAuthHeaders()
    });
    
    if (!response.ok) throw new Error('Erreur lors de la récupération des produits');
    
    const data = await response.json();
    products.value = data.products.map(product => ({
      ...product,
      isEditing: false
    }));
  } catch (err) {
    handleError(err, 'Erreur lors de la récupération des produits');
  } finally {
    loading.value = false;
  }
};

const fetchCategories = async () => {
  try {
    const response = await fetch(`${API_BASE_URL}/categories`, {
      headers: getAuthHeaders()
    });
    
    if (!response.ok) throw new Error('Erreur lors de la récupération des catégories');
    
    const data = await response.json();
    categories.value = Array.isArray(data) ? data : data.categories || [];
    
    if (categories.value.length === 0) {
      console.warn('Aucune catégorie disponible');
    }
  } catch (err) {
    handleError(err, 'Erreur lors de la récupération des catégories');
  }
};

const saveProduct = async (product) => {
  try {
    error.value = null;
    const formData = new FormData();
    
    // Vérification de la catégorie
    if (!product.category_id) {
      throw new Error('La catégorie est requise');
    }
    
    // Ajout des champs au FormData
    formData.append('name', product.name);
    formData.append('description', product.description);
    formData.append('price', product.price);
    formData.append('stock', product.stock);
    formData.append('weight', product.weight);
    formData.append('ingredients', product.ingredients);
    formData.append('category_id', product.category_id);
    
    // Ajout de la nouvelle image si elle existe
    if (product.newImage) {
      formData.append('image', product.newImage);
    }

    // Debug: Afficher les données envoyées
    console.log('Données envoyées:', {
      name: product.name,
      description: product.description,
      price: product.price,
      stock: product.stock,
      weight: product.weight,
      ingredients: product.ingredients,
      category_id: product.category_id
    });

    const response = await fetch(`${API_BASE_URL}/products/${product.id}`, {
      method: 'PUT',
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      },
      body: formData
    });
    
    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || 'Erreur lors de la modification du produit');
    }
    
    product.isEditing = false;
    product.newImage = null;
    await fetchProducts(); // Rafraîchir la liste pour obtenir la nouvelle URL de l'image
  } catch (err) {
    handleError(err, 'Erreur lors de la modification du produit');
  }
};

const deleteProduct = async () => {
  try {
    error.value = null;
    const response = await fetch(`${API_BASE_URL}/products/${productToDelete.value.id}`, {
      method: 'DELETE',
      headers: getAuthHeaders()
    });
    
    if (!response.ok) throw new Error('Erreur lors de la suppression du produit');
    
    products.value = products.value.filter(product => product.id !== productToDelete.value.id);
    dialog.value = false;
    productToDelete.value = null;
  } catch (err) {
    handleError(err, 'Erreur lors de la suppression du produit');
  }
};

const createProduct = async () => {
  try {
    error.value = null;
    const formData = new FormData();
    
    // Ajout des champs au FormData
    Object.keys(newProduct.value).forEach(key => {
      if (key === 'image' && newProduct.value[key]) {
        formData.append('image', newProduct.value[key]);
      } else if (key !== 'image') {
        formData.append(key, newProduct.value[key]);
      }
    });

    const response = await fetch(`${API_BASE_URL}/products`, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      },
      body: formData
    });
    
    if (!response.ok) throw new Error('Erreur lors de la création du produit');
    
    createDialog.value = false;
    await fetchProducts();
  } catch (err) {
    handleError(err, 'Erreur lors de la création du produit');
  }
};

// Méthodes UI
const editProduct = (product) => {
  product.isEditing = true;
  product.newImage = null;
  product.category_id = product.category.id; // Initialiser category_id avec l'ID de la catégorie existante
};

const confirmDelete = (product) => {
  productToDelete.value = product;
  dialog.value = true;
};

const openCreateDialog = () => {
  createDialog.value = true;
  newProduct.value = { ...DEFAULT_PRODUCT };
};

onMounted(() => {
  fetchProducts();
  fetchCategories();
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
