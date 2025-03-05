<template>
  <v-container class="py-10 d-flex flex-column align-center artisan-container">
    <!-- Titre de la page -->
    <h1 class="text-center mb-10 artisan-title">Mon Compte</h1>
    <h2 class="text-center mb-6 artisan-subtitle">Connectez-vous</h2>

    <v-row justify="center" class="w-100">
      <v-col cols="12" sm="8" md="6" lg="4">
        <v-card class="pa-6 artisan-form" elevation="0">
          <v-form @submit.prevent="handleLogin" ref="form">
            <v-text-field
              v-model="email"
              label="Email"
              type="email"
              variant="outlined"
              class="mb-4"
              :rules="[rules.required, rules.email]"
              required
            ></v-text-field>

            <v-text-field
              v-model="password"
              label="Mot de passe"
              type="password"
              variant="outlined"
              class="mb-6"
              :rules="[rules.required]"
              required
            ></v-text-field>

            <v-btn
              type="submit"
              class="artisan-btn mb-4"
              block
              :loading="loading"
            >
              Se connecter
            </v-btn>

            <div class="text-center">
              <a href="#" class="text-decoration-none artisan-link">Mot de passe oublié ?</a>
            </div>
          </v-form>

          <v-divider class="my-6"></v-divider>

          <div class="text-center">
            <p class="mb-4 text-black">Pas encore de compte ?</p>
            <nuxt-link to="/register">
                <v-btn
              class="artisan-btn-outline"
              block
              @click="goToRegister"
            >
              Créer un compte
            </v-btn>
            </nuxt-link>
            
          </div>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const form = ref(null);
const loading = ref(false);
const email = ref('');
const password = ref('');

const rules = {
  required: v => !!v || 'Ce champ est requis',
  email: v => /.+@.+\..+/.test(v) || 'Email invalide'
};

const handleLogin = async () => {
  const { valid } = await form.value.validate();
  if (valid) {
    loading.value = true;
    // TODO: Implémenter la logique de connexion
    setTimeout(() => {
      loading.value = false;
      router.push('/');
    }, 1500);
  }
};

const goToRegister = () => {
  // TODO: Implémenter la navigation vers la page d'inscription
  console.log('Navigation vers la page d\'inscription');
};
</script>

<style scoped>
.artisan-container {
  min-height: 100vh;
  background: #ffffff;
  padding: 50px 20px;
  margin-top: 60px;
  position: relative;
}

.artisan-title {
  font-size: 3.8rem;
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 3px;
  text-align: center;
  color: #000000;
  margin: 60px 0;
  position: relative;
  font-family: 'Playfair Display', serif;
}

.artisan-title::after,
.artisan-subtitle::after {
  content: "";
  display: block;
  height: 1px;
  background: #000000;
  margin: 20px auto 0;
}

.artisan-title::after {
  width: 100px;
}

.artisan-subtitle {
  font-size: 2.6rem;
  font-weight: 400;
  text-align: center;
  color: #000000;
  margin-bottom: 30px;
  letter-spacing: 1px;
  font-family: 'Playfair Display', serif;
  position: relative;
}

.artisan-subtitle::after {
  width: 60px;
  margin: 15px auto 0;
}

.artisan-form {
  background: #ffffff;
  border: 1px solid rgba(0, 0, 0, 0.1);
  transition: all 0.4s ease;
}

.artisan-form:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
}

.artisan-btn {
  background: #000000;
  color: #ffffff;
  font-size: 1rem;
  padding: 12px 30px;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-radius: 0;
  border: 1px solid #000000;
  transition: all 0.3s ease;
  font-family: 'Montserrat', sans-serif;
}

.artisan-btn:hover {
  background: #ffffff;
  color: #000000;
  transform: translateY(-2px);
}

.artisan-btn-outline {
  background: #ffffff;
  color: #000000;
  font-size: 1rem;
  padding: 12px 30px;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-radius: 0;
  border: 1px solid #000000;
  transition: all 0.3s ease;
  font-family: 'Montserrat', sans-serif;
}

.artisan-btn-outline:hover {
  background: #000000;
  color: #ffffff;
  transform: translateY(-2px);
}

.artisan-link {
  color: #000000;
  font-size: 0.9rem;
  text-decoration: none;
  transition: all 0.3s ease;
}

.artisan-link:hover {
  opacity: 0.7;
}

/* Styles Vuetify optimisés */
:deep(.v-field__input) {
  color: #000000 !important;
}

:deep(.v-field__outline) {
  color: rgba(0, 0, 0, 0.2) !important;
}

:deep(.v-field--focused .v-field__outline) {
  color: #000000 !important;
}

:deep(.v-label) {
  color: rgba(0, 0, 0, 0.8) !important;
}

:deep(.v-messages) {
  color: #d32f2f !important;
}
</style>