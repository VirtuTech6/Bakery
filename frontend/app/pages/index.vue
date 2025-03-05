<template>
  <v-container fluid class="pa-0">
    <!-- Image principale avec texte -->
    <v-img src="/home-banner.jpg" class="home-image" cover>
      <div class="overlay">
        <h2 class="welcome-title">
          <span class="dot">•</span> Bienvenue <span class="dot">•</span>
        </h2>
        <h1 class="overlay-text">L’authenticité du pain artisanal</h1>
      </div>
    </v-img>
  </v-container>
</template>

<style scoped>
/* Image principale */
.home-image {
  height: 100vh; /* Plein écran */
  position: relative;
}

.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-color: rgba(0, 0, 0, 0.4); /* Assombrissement */
  text-align: center;
  padding: 0 20px;
}

.welcome-title {
  font-size: 1.8rem;
  font-weight: bold;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  margin-bottom: 10px;
}

.dot {
  font-size: 1.5rem;
  color: #c49a6c; /* Couleur dorée */
}

.overlay-text {
  color: white;
  font-size: 3.5rem;
  font-weight: bold;
  text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
  max-width: 80%;
}

/* Section Description */
.welcome-section {
  max-width: 800px;
  margin: auto;
  padding: 60px 20px;
}

/* Responsive */
@media (max-width: 768px) {
  .home-image {
    height: 80vh;
  }
  .overlay-text {
    font-size: 2rem;
    max-width: 90%;
  }
  .welcome-title {
    font-size: 1.5rem;
  }
  .dot {
    font-size: 1.2rem;
  }
}
</style>
