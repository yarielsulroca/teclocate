<template>
    <div>
      <h1>Importar Clientes</h1>
      <form @submit.prevent="importClients">
        <input type="file" @change="handleFileUpload" />
        <button type="submit">Importar</button>
      </form>
      <div v-if="message" class="alert alert-success">{{ message }}</div>
      <div v-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  import axios from 'axios';

  const file = ref(null);
  const message = ref('');
  const errorMessage = ref('');

  const handleFileUpload = (event) => {
    file.value = event.target.files[0];
  };

  const importClients = async () => {
    if (!file.value) {
      console.error('No file selected');
      return;
    }

    const formData = new FormData();
    formData.append('import_file', file.value);

    try {
      const response = await axios.post('/clientes/import', formData);
      message.value = response.data.message;
      errorMessage.value = ''; // Clear error message if request is successful
    } catch (error) {
      console.error('Error importing clients:', error);
      errorMessage.value = error.response.data.message || 'Error importing clients.';
      message.value = ''; // Clear success message if there is an error
    }
  };
  </script>

  <style>
  .alert {
    margin-top: 20px;
  }
  </style>
