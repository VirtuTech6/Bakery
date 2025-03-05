<template>
  <div class="history-page">
    <!-- Section En-tête -->
    <v-img src="/bakery-history.jpg" class="home-image" cover>
        <section class="hero-section">
      <div class="hero-content">
        <h1>Notre Histoire</h1>
        <p>Une tradition de passion et d'excellence depuis 1990</p>
      </div>
    </section>
    </v-img>
    

    <!-- Section Histoire -->
    <section class="history-section">
      <div class="container">
        <div class="history-content">
          <div class="history-text">
            <h2>Notre Histoire</h2>
            <p>Depuis plus de 30 ans, notre boulangerie perpétue la tradition du pain artisanal. Fondée en 1990 par la famille Martin, nous avons su préserver les secrets d'une boulangerie authentique tout en innovant pour répondre aux attentes de nos clients.</p>
            <p>Notre engagement envers la qualité et l'authenticité nous a permis de devenir une référence dans la région, appréciée pour nos pains traditionnels et nos pâtisseries raffinées.</p>
          </div>
          <div class="history-image">
            <img class="history-image" src="/boulanger.jpg" alt="Notre boulangerie en 1990" />
          </div>
        </div>
      </div>
    </section>

    <!-- Section Valeurs -->
    <section class="values-section">
      <div class="container">
        <h2>Nos Valeurs</h2>
        <div class="values-grid">
          <div class="value-card">
            <i class="fas fa-heart"></i>
            <h3>Passion</h3>
            <p>L'amour du métier dans chaque création</p>
          </div>
          <div class="value-card">
            <i class="fas fa-seedling"></i>
            <h3>Authenticité</h3>
            <p>Des recettes traditionnelles préservées</p>
          </div>
          <div class="value-card">
            <i class="fas fa-handshake"></i>
            <h3>Engagement</h3>
            <p>Un service client personnalisé</p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
// Le composant est configuré avec la composition API de Vue 3
</script>

<style scoped>

.home-image {
  height: 60vh; /* Plein écran */
  position: relative;
}

.history-page {
  font-family: 'Playfair Display', serif;
}

.history-image {
  width: 40vh;
  object-fit: cover;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  filter: grayscale(100%);
}

.hero-section {
  height: 60vh;
  background-image: url('/images/bakery-hero.jpg');
  background-size: cover;
  background-position: center;
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

.history-section {
  padding: 5rem 0;
  background-color: #fff;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 2rem;
}

.history-content {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 4rem;
  align-items: center;
}

.history-text h2 {
  font-size: 2.5rem;
  margin-bottom: 2rem;
  color: #333;
}

.history-text p {
  margin-bottom: 1.5rem;
  line-height: 1.8;
  color: #666;
}

.history-image img {
  width: 100%;
  height: auto;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.values-section {
  padding: 5rem 0;
  background-color: #f9f9f9;
}

.values-section h2 {
  text-align: center;
  font-size: 2.5rem;
  margin-bottom: 3rem;
  color: #333;
}

.values-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2rem;
}

.value-card {
  text-align: center;
  padding: 2rem;
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  transition: transform 0.3s ease;
}

.value-card:hover {
  transform: translateY(-5px);
}

.value-card i {
  font-size: 2.5rem;
  color: #d4af37;
  margin-bottom: 1rem;
}

.value-card h3 {
  font-size: 1.5rem;
  margin-bottom: 1rem;
  color: #333;
}

.value-card p {
  color: #666;
  line-height: 1.6;
}

@media (max-width: 768px) {
  .history-content {
    grid-template-columns: 1fr;
  }
  
  .values-grid {
    grid-template-columns: 1fr;
  }
  
  .hero-content h1 {
    font-size: 2.5rem;
  }
}
</style>
