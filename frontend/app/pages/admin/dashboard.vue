<template>
  <v-container fluid>
    <v-row>
      <AdminNav />
      <v-col class="v-col" cols="12" sm="8" md="9" lg="10">
        <v-card>
          <v-card-title>Tableau de bord</v-card-title>
          <v-card-text>
            <p>Bienvenue dans votre espace d'administration</p>
            <div class="date-container">
              
              <v-menu
                v-model="showDatePicker"
                :close-on-content-click="false"
                transition="scale-transition"
                offset="10"
              >
                <template v-slot:activator="{ props }">
                  <v-btn
                    v-bind="props"
                    variant="text"
                    class="date-button"
                    prepend-icon="mdi-calendar"
                  >
                    {{ formattedDate }}
                  </v-btn>
                </template>

                <v-date-picker
                  v-model="selectedDate"
                  @update:model-value="handleDateSelect"
                  :first-day-of-week="1"
                  locale="fr-FR"
                  elevation="2"
                  color="black"
                  border
                ></v-date-picker>
              </v-menu>
            </div>

            <!-- Affichage des résultats -->
            <v-card v-if="products.length > 0" class="mt-4">
              <v-table>
                <thead>
                  <tr>
                    <th>Produit</th>
                    <th class="text-right">Quantité vendue</th>
                    <th class="text-right">Montant total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="product in products" :key="product.id">
                    <td>{{ product.name }}</td>
                    <td class="text-right">{{ product.totalQuantity }}</td>
                    <td class="text-right">{{ formatPrice(product.totalAmount) }}€</td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td class="text-right font-weight-bold">Total</td>
                    <td class="text-right font-weight-bold">{{ totalQuantity }}</td>
                    <td class="text-right font-weight-bold">{{ formatPrice(totalAmount) }}€</td>
                  </tr>
                </tfoot>
              </v-table>
            </v-card>
            <v-alert
              v-else-if="hasSearched"
              type="info"
              class="mt-4"
            >
              Aucune vente pour cette date
            </v-alert>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import AdminNav from '~/components/AdminNav.vue';
import { ref, computed } from 'vue';

definePageMeta({
  middleware: ['admin']
});

const showDatePicker = ref(false);
const selectedDate = ref(new Date());
const products = ref([]);
const hasSearched = ref(false);

const formattedDate = computed(() => {
  return new Intl.DateTimeFormat('fr-FR', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  }).format(selectedDate.value);
});

const totalQuantity = computed(() => {
  return products.value.reduce((sum, product) => sum + product.totalQuantity, 0);
});

const totalAmount = computed(() => {
  return products.value.reduce((sum, product) => sum + product.totalAmount, 0);
});

const formatPrice = (price) => {
  return Number(price).toLocaleString('fr-FR', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });
};

const fetchProductsByDate = async (date) => {
  try {
    const adjustedDate = new Date(date);
    adjustedDate.setDate(adjustedDate.getDate() + 1);
    const formattedDate = adjustedDate.toISOString().split('T')[0];
    
    const token = localStorage.getItem('token');
    const response = await fetch(`http://localhost:8000/api/orders/by-date/${formattedDate}`, {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
      }
    });
    if (!response.ok) throw new Error('Erreur lors de la récupération des données');
    const data = await response.json();
    products.value = data;
    hasSearched.value = true;
  } catch (error) {
    console.error('Erreur:', error);
    products.value = [];
  }
};

const handleDateSelect = (date) => {
  selectedDate.value = new Date(date);
  showDatePicker.value = false;
  fetchProductsByDate(selectedDate.value);
};

// Charger les données pour la date actuelle au chargement
fetchProductsByDate(selectedDate.value);

const getWeekday = (date) => {
  return new Intl.DateTimeFormat('fr-FR', { weekday: 'short' }).format(date);
};

const getMonth = (date) => {
  return new Intl.DateTimeFormat('fr-FR', { month: 'long' }).format(date);
};
</script>

<style scoped>
/* Variables CSS */
:root {
  --primary-color: #000000;
  --secondary-color: rgba(0, 0, 0, 0.1);
  --hover-color: rgba(0, 0, 0, 0.02);
  --shadow-color: rgba(0, 0, 0, 0.05);
  --hover-shadow-color: rgba(0, 0, 0, 0.1);
  --text-color: #000000;
}

.v-container {
  min-height: 100vh;
  background: #ffffff;
  padding: 50px 20px;
  margin-top: 60px;
  position: relative;
  color: var(--text-color);
}

.v-card {
  background: #ffffff;
  border: 1px solid var(--secondary-color);
  transition: all 0.4s ease;
  border-radius: 8px;
  box-shadow: 0 4px 20px var(--shadow-color);
  color: var(--text-color);
}

.v-card :deep(.v-card-title) {
  color: var(--text-color);
  font-weight: 600;
}

.v-card :deep(.v-card-text) {
  color: var(--text-color);
}

.v-card:hover {
  box-shadow: 0 8px 30px var(--hover-shadow-color);
}

.date-container {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  margin: 10px 0;
  position: relative;
}

.date-button {
  font-family: 'Montserrat', sans-serif;
  font-size: 0.9rem;
  color: var(--text-color) !important;
  text-transform: none;
  letter-spacing: 0.5px;
  border: 1px solid var(--secondary-color);
  padding: 0 16px;
}

:deep(.v-date-picker) {
  color: var(--text-color);
  background-color: white;
  border: 1px solid var(--secondary-color);
  box-shadow: 0 4px 20px var(--shadow-color);
}

:deep(.v-date-picker-month__day) {
  color: var(--text-color) !important;
}

:deep(.v-date-picker-controls button) {
  color: var(--text-color) !important;
}

:deep(.v-date-picker-month__weekday) {
  color: var(--text-color) !important;
}

:deep(.v-date-picker-month__day--selected) {
  background-color: black !important;
  color: white !important;
}

@media (max-width: 960px) {
  .v-container {
    padding: 30px 15px;
    margin-top: 40px;
  }
}

@media (max-width: 600px) {
  .v-container {
    padding: 20px 10px;
    margin-top: 30px;
  }

  .v-card {
    padding: 15px;
  }

  .date-container {
    margin-top: 10px;
    padding: 5px;
  }
}

@media print {
  .v-container {
    margin: 0;
    padding: 0;
  }

  .v-card {
    box-shadow: none !important;
    border: none !important;
  }
}

.v-table {
  background-color: white !important;
  color: var(--text-color) !important;
}

.v-table th {
  color: var(--text-color) !important;
  font-weight: 600 !important;
  text-transform: uppercase;
  font-size: 0.9rem;
}

.v-table td {
  color: var(--text-color) !important;
}

.v-table tfoot tr {
  background-color: var(--hover-color);
}
</style>


