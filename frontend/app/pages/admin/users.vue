<template>
    <v-container fluid>
      <v-row>
        <AdminNav />
        <v-col class="v-col" cols="12" sm="8" md="9" lg="10">
          <v-card>
            <v-card-title>Utilisateurs</v-card-title>
            <v-card-text>
              <v-data-table
                :headers="headers"
                :items="users"
                :loading="loading"
                class="elevation-1"
              >
                <template v-slot:item="{ item }">
                  <tr>
                    <td>{{ item.id }}</td>
                    <td>
                      <v-text-field
                        v-if="item.isEditing"
                        v-model="item.firstName"
                        dense
                        hide-details
                      ></v-text-field>
                      <span v-else>{{ item.firstName }}</span>
                    </td>
                    <td>
                      <v-text-field
                        v-if="item.isEditing"
                        v-model="item.lastName"
                        dense
                        hide-details
                      ></v-text-field>
                      <span v-else>{{ item.lastName }}</span>
                    </td>
                    <td>
                      <v-text-field
                        v-if="item.isEditing"
                        v-model="item.email"
                        dense
                        hide-details
                      ></v-text-field>
                      <span v-else>{{ item.email }}</span>
                    </td>
                    <td>
                      <v-text-field
                        v-if="item.isEditing"
                        v-model="item.address"
                        dense
                        hide-details
                      ></v-text-field>
                      <span v-else>{{ item.address }}</span>
                    </td>
                    <td>
                      <v-text-field
                        v-if="item.isEditing"
                        v-model="item.phone"
                        dense
                        hide-details
                      ></v-text-field>
                      <span v-else>{{ item.phone }}</span>
                    </td>
                    <td>
                      <v-select
                        v-if="item.isEditing"
                        v-model="item.role"
                        :items="['ROLE_USER', 'ROLE_MANAGER']"
                        dense
                        hide-details
                      ></v-select>
                      <span v-else>{{ item.role }}</span>
                    </td>
                    <td>{{ item.createdAt }}</td>
                    <td>
                      <div class="d-flex gap-2">
                        <v-btn
                          v-if="item.isEditing"
                          color="success"
                          small
                          @click="saveUser(item)"
                        >
                          Sauvegarder
                        </v-btn>
                        <template v-else>
                          <v-btn
                            color="primary"
                            small
                            @click="editUser(item)"
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
                Nouvel utilisateur
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>

      <!-- Boîte de dialogue de création -->
      <v-dialog v-model="createDialog" max-width="600">
        <v-card>
          <v-card-title>Créer un nouvel utilisateur</v-card-title>
          <v-card-text>
            <v-form ref="form" v-model="valid">
              <v-row>
                <v-col cols="12" sm="6">
                  <v-text-field
                    v-model="newUser.firstName"
                    label="Prénom"
                    :rules="[v => !!v || 'Le prénom est requis']"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6">
                  <v-text-field
                    v-model="newUser.lastName"
                    label="Nom"
                    :rules="[v => !!v || 'Le nom est requis']"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    v-model="newUser.email"
                    label="Email"
                    :rules="[
                      v => !!v || 'L\'email est requis',
                      v => /.+@.+\..+/.test(v) || 'L\'email doit être valide'
                    ]"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    v-model="newUser.password"
                    label="Mot de passe"
                    type="password"
                    :rules="[v => !!v || 'Le mot de passe est requis']"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    v-model="newUser.address"
                    label="Adresse"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    v-model="newUser.phone"
                    label="Téléphone"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-select
                    v-model="newUser.role"
                    :items="['ROLE_USER', 'ROLE_MANAGER']"
                    label="Rôle"
                  ></v-select>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="grey" text @click="createDialog = false">Annuler</v-btn>
            <v-btn color="primary" text @click="createUser" :disabled="!valid">Créer</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <!-- Boîte de dialogue de confirmation -->
      <v-dialog v-model="dialog" max-width="400">
        <v-card>
          <v-card-title>Confirmer la suppression</v-card-title>
          <v-card-text>
            Êtes-vous sûr de vouloir supprimer cet utilisateur ?
            Cette action est irréversible.
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="grey" text @click="dialog = false">Annuler</v-btn>
            <v-btn color="error" text @click="deleteUser">Supprimer</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>
  </template>
  
  <script setup>
  import AdminNav from '~/components/AdminNav.vue';
  import { ref, onMounted, computed } from 'vue';
  
  definePageMeta({
    middleware: ['admin']
  });
  
  // Constantes
  const API_BASE_URL = 'http://localhost:8000/api';
  const DEFAULT_USER = {
    firstName: '',
    lastName: '',
    email: '',
    password: '',
    address: '',
    phone: '',
    role: 'ROLE_USER'
  };
  
  // États
  const loading = ref(false);
  const users = ref([]);
  const dialog = ref(false);
  const userToDelete = ref(null);
  const createDialog = ref(false);
  const valid = ref(false);
  const form = ref(null);
  const error = ref(null);
  
  // Headers de la table
  const headers = [
    { title: 'ID', key: 'id', width: '80px' },
    { title: 'Prénom', key: 'firstName', width: '150px' },
    { title: 'Nom', key: 'lastName', width: '150px' },
    { title: 'Email', key: 'email', width: '250px' },
    { title: 'Adresse', key: 'address', width: '200px' },
    { title: 'Téléphone', key: 'phone', width: '120px' },
    { title: 'Rôle', key: 'role', width: '120px' },
    { title: 'Date de création', key: 'createdAt', width: '150px' },
    { title: 'Actions', key: 'actions', width: '120px' }
  ];
  
  const newUser = ref({ ...DEFAULT_USER });
  
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
  const fetchUsers = async () => {
    try {
      loading.value = true;
      error.value = null;
      const response = await fetch(`${API_BASE_URL}/users`, {
        headers: getAuthHeaders()
      });
      
      if (!response.ok) throw new Error('Erreur lors de la récupération des utilisateurs');
      
      const data = await response.json();
      users.value = data.map(user => ({
        ...user,
        isEditing: false
      }));
    } catch (err) {
      handleError(err, 'Erreur lors de la récupération des utilisateurs');
    } finally {
      loading.value = false;
    }
  };
  
  const saveUser = async (user) => {
    try {
      error.value = null;
      const response = await fetch(`${API_BASE_URL}/user/${user.id}`, {
        method: 'PUT',
        headers: getAuthHeaders(),
        body: JSON.stringify({
          firstName: user.firstName,
          lastName: user.lastName,
          email: user.email,
          address: user.address,
          phone: user.phone,
          role: user.role
        })
      });
      
      if (!response.ok) throw new Error('Erreur lors de la modification de l\'utilisateur');
      
      user.isEditing = false;
    } catch (err) {
      handleError(err, 'Erreur lors de la modification de l\'utilisateur');
    }
  };
  
  const deleteUser = async () => {
    try {
      error.value = null;
      const response = await fetch(`${API_BASE_URL}/user/${userToDelete.value.id}`, {
        method: 'DELETE',
        headers: getAuthHeaders()
      });
      
      if (!response.ok) throw new Error('Erreur lors de la suppression de l\'utilisateur');
      
      users.value = users.value.filter(user => user.id !== userToDelete.value.id);
      dialog.value = false;
      userToDelete.value = null;
    } catch (err) {
      handleError(err, 'Erreur lors de la suppression de l\'utilisateur');
    }
  };
  
  const createUser = async () => {
    try {
      error.value = null;
      const response = await fetch(`${API_BASE_URL}/user`, {
        method: 'POST',
        headers: getAuthHeaders(),
        body: JSON.stringify(newUser.value)
      });
      
      if (!response.ok) throw new Error('Erreur lors de la création de l\'utilisateur');
      
      createDialog.value = false;
      await fetchUsers();
    } catch (err) {
      handleError(err, 'Erreur lors de la création de l\'utilisateur');
    }
  };
  
  // Méthodes UI
  const editUser = (user) => {
    user.isEditing = true;
  };
  
  const confirmDelete = (user) => {
    userToDelete.value = user;
    dialog.value = true;
  };
  
  const openCreateDialog = () => {
    createDialog.value = true;
    newUser.value = { ...DEFAULT_USER };
  };
  
  onMounted(() => {
    fetchUsers();
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

  .v-card-title {
    color: #000000 !important;
}
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
  </style>
  
  
  