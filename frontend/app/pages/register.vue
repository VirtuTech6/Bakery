<template>
  <v-container class="py-10 d-flex flex-column align-center artisan-container">
    <!-- Titre de la page -->
    <h1 class="text-center mb-10 artisan-title">Mon Compte</h1>
    <h2 class="text-center mb-6 artisan-subtitle">Créez votre compte</h2>

    <v-row justify="center" class="w-100">
      <v-col cols="12" sm="8" md="6" lg="4">
        <v-card class="pa-6 artisan-form" elevation="0">
          <v-form @submit.prevent="handleRegister" ref="form">
            <v-text-field
              v-model="firstName"
              label="Prénom"
              variant="outlined"
              class="mb-4"
              :rules="[rules.required]"
              required
            ></v-text-field>

            <v-text-field
              v-model="lastName"
              label="Nom"
              variant="outlined"
              class="mb-4"
              :rules="[rules.required]"
              required
            ></v-text-field>

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
              class="mb-4"
              :rules="[rules.required, rules.password]"
              required
            ></v-text-field>

            <v-text-field
              v-model="confirmPassword"
              label="Confirmer le mot de passe"
              type="password"
              variant="outlined"
              class="mb-6"
              :rules="[rules.required, rules.passwordMatch]"
              required
            ></v-text-field>

            <v-checkbox
              v-model="acceptTerms"
              label="J'accepte les conditions d'utilisation"
              class="mb-6"
              :rules="[rules.required]"
              required
            ></v-checkbox>

            <v-btn
              type="submit"
              class="artisan-btn mb-4"
              block
              :loading="loading"
            >
              Créer mon compte
            </v-btn>
          </v-form>

          <v-divider class="my-6"></v-divider>

          <div class="text-center">
            <p class="mb-4 text-black">Déjà un compte ?</p>
            <nuxt-link to="/account">
              <v-btn
                class="artisan-btn-outline"
                block
              >
                Se connecter
              </v-btn>
            </nuxt-link>
          </div>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const form = ref(null);
const loading = ref(false);

const firstName = ref('');
const lastName = ref('');
const email = ref('');
const password = ref('');
const confirmPassword = ref('');
const acceptTerms = ref(false);

const rules = {
  required: v => !!v || 'Ce champ est requis',
  email: v => /.+@.+\..+/.test(v) || 'Email invalide',
  password: v => v.length >= 8 || 'Le mot de passe doit contenir au moins 8 caractères',
  passwordMatch: v => v === password.value || 'Les mots de passe ne correspondent pas'
};

const handleRegister = async () => {
  const { valid } = await form.value.validate();
  if (valid) {
    loading.value = true;
    // TODO: Implémenter la logique d'inscription
    setTimeout(() => {
      loading.value = false;
      router.push('/account');
    }, 1500);
  }
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

:deep(.v-checkbox .v-label) {
  color: rgba(0, 0, 0, 0.8) !important;
}

:deep(.v-checkbox .v-checkbox__input) {
  border-color: rgba(0, 0, 0, 0.8) !important;
}

:deep(.v-checkbox--selected .v-checkbox__input) {
  background-color: #000000 !important;
  border-color: #000000 !important;
}

.artisan-container::before {
  content: "";
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23000000' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
  pointer-events: none;
  z-index: 0;
}
</style>
