<template>
  <div>
    <form @submit.prevent="handleSubmit">
      <label for="businessId">Business ID:</label>
      <input
        type="text"
        id="businessId"
        v-model="businessId"
        placeholder="Enter Business ID"
      />
      <button type="submit">Fetch Data</button>
    </form>

    <div v-if="data">
      <h3>Business Data:</h3>
      <pre>{{ formattedData }}</pre>
    </div>

    <div v-if="error" class="error">
      <p>Error: {{ error }}</p>
    </div>
  </div>
</template>

<script>
import axios from '../api/axios'; // Adjust the path as necessary

export default {
  data() {
    return {
      businessId: '',
      data: null,
      error: null,
    };
  },
  computed: {
    formattedData() {
      if (this.data) {
        // Format or process the data as needed for display
        return JSON.stringify(this.data, null, 2); // Pretty-print JSON
      }
      return '';
    },
  },
  methods: {
    async handleSubmit() {
      try {
        const response = await axios.get(`/business/${this.businessId}`);
        if (response.data.code === '00') {
          this.data = response.data.data;
          this.error = null; // Clear previous errors
        } else {
          this.error = response.data.desc || 'An unknown error occurred.';
          this.data = null; // Clear previous data
        }
      } catch (err) {
        this.error = err.message;
        this.data = null; // Clear previous data
      }
    },
  },
};
</script>

<style scoped>
.error {
  color: red;
}
</style>
