<template>
  <div class="commande-page">
    <!-- Section En-tête -->
    <v-img src="/bakery-history.jpg" class="home-image" cover>
      <section class="hero-section">
        <div class="hero-content">
          <h1>Nos Produits</h1>
          <p>Découvrez notre sélection de produits artisanaux</p>
        </div>
      </section>
    </v-img>

    <!-- Section Filtres et Produits -->
    <section class="products-section">
      <div class="container">
        <!-- Filtres -->
        <div class="filters-container">
          <v-select
            v-model="selectedCategory"
            :items="categories"
            label="Catégorie"
            class="filter-select"
            hide-details
            @update:model-value="filterProducts"
          ></v-select>
          
          <v-text-field
            v-model="searchQuery"
            label="Rechercher un produit"
            prepend-icon="mdi-magnify"
            class="filter-search"
            @input="filterProducts"
          ></v-text-field>
        </div>

        <!-- Grille de Produits -->
        <div class="products-grid">
          <div v-for="product in filteredProducts" :key="product.id" class="product-card">
            <nuxt-link :to="`/produit/${product.id}`" class="artisan-image-link">
              <v-img :src="product.image" :alt="product.name" class="product-image"></v-img>
            </nuxt-link>
            <div class="product-info">
              <h3>{{ product.name }}</h3>
              <p class="product-description">{{ product.description }}</p>
              <p class="product-price">{{ product.price }}€</p>
              <v-btn class="btn-black" @click="addToCart(product)">
                Ajouter au panier
              </v-btn>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const categories = [
  'Tous',
  'Pains',
  'Viennoiseries',
  'Pâtisseries',
  'Sandwichs'
]

const selectedCategory = ref('Tous')
const searchQuery = ref('')

// Initialiser le filtre de catégorie depuis l'URL
onMounted(() => {
  const categoryFromUrl = route.query.category
  if (categoryFromUrl && categories.includes(categoryFromUrl)) {
    selectedCategory.value = categoryFromUrl
  }
})

const products = ref([
  
    { id: 1, name: 'Pain de campagne', description: 'Pain traditionnel à la mie dense et à la croûte croustillante, fabriqué avec de la farine de blé et de seigle.', price: 2.5, image: '/produits/paindecampagne.jpeg', category: 'Pains', popular: true },
    { id: 2, name: 'Brioche', description: 'Pâtisserie moelleuse et légère au beurre, parfaite pour le petit-déjeuner ou le goûter.', price: 3.2, image: '/produits/brioche.jpeg', category: 'Viennoiseries', popular: false },
    { id: 3, name: 'Chocolatine', description: 'Viennoiserie feuilletée garnie de deux barres de chocolat noir, croustillante à l\'extérieur et fondante à l\'intérieur.', price: 1.8, image: '/produits/painauchocolat.jpeg', category: 'Viennoiseries', popular: true },
    { id: 4, name: 'Fougasse', description: 'Le classique sandwich français avec du jambon blanc, du beurre de qualité et une baguette fraîche et croustillante.', price: 4.5, image: '/produits/fougasse.jpeg', category: 'Sandwichs', popular: false },
])

const filteredProducts = computed(() => {
  return products.value.filter(product => {
    const matchesCategory = selectedCategory.value === 'Tous' || product.category === selectedCategory.value
    const matchesSearch = product.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                         product.description.toLowerCase().includes(searchQuery.value.toLowerCase())
    return matchesCategory && matchesSearch
  })
})

const filterProducts = () => {
  // Mettre à jour l'URL avec la catégorie sélectionnée
  const query = { ...route.query }
  if (selectedCategory.value === 'Tous') {
    delete query.category
  } else {
    query.category = selectedCategory.value
  }
  navigateTo({ query })
}

const addToCart = (product) => {
  // Logique d'ajout au panier à implémenter
  console.log('Ajout au panier:', product)
}
</script>

<style scoped>
.commande-page {
  font-family: 'Playfair Display', serif;
}

.home-image {
  height: 60vh;
  position: relative;
}

.hero-section {
  height: 60vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  color: white;
  position: relative;
}

.hero-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
}

.hero-content {
  position: relative;
  z-index: 1;
}

.hero-content h1 {
  font-size: 3.5rem;
  margin-bottom: 1rem;
}

.hero-content p {
  font-size: 1.2rem;
  font-style: italic;
}

.products-section {
  padding: 5rem 0;
  background-color: #fff;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 2rem;
}

.filters-container {
  display: flex;
  gap: 2rem;
  margin-bottom: 3rem;
}

.filter-select {
  max-width: 300px;
}

.filter-search {
  max-width: 300px;
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 2rem;
  width: 100%;
}

.product-card {
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: transform 0.3s ease;
  display: flex;
  flex-direction: column;
  height: 100%;
}

.product-card:hover {
  transform: translateY(-5px);
}

.artisan-image-link {
  display: block;
  width: 100%;
  height: 300px;
  overflow: hidden;
}

.product-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: all 0.4s ease;
}

.product-image:hover {
  transform: scale(1.05);
}

.product-info {
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
}

.product-info h3 {
  font-size: 1.5rem;
  margin-bottom: 0.5rem;
  color: #333;
}

.product-description {
  color: #666;
  margin-bottom: 1rem;
  line-height: 1.6;
}

.product-price {
  font-size: 1.25rem;
  font-weight: bold;
  color: #000;
  margin-bottom: 1rem;
}

.btn-black {
  background: #000000;
  color: #ffffff;
  font-size: 1.1rem;
  padding: 12px 30px;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-radius: 0;
  border: 1px solid #000000;
  transition: all 0.3s ease;
  font-family: 'Montserrat', sans-serif;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.btn-black:hover {
  background: #ffffff;
  color: #000000;
}

@media (max-width: 768px) {
  .filters-container {
    flex-direction: column;
  }
  
  .filter-select,
  .filter-search {
    max-width: 100%;
  }
  
  .hero-content h1 {
    font-size: 2.5rem;
  }
}
</style>
