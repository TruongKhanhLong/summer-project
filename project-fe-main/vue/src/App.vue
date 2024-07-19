<!-- <script setup>
//
</script>

<template>
  <router-view></router-view>
</template>

<style>
</style> -->
<template>
  <div id="app">
    <MyComponent />
  </div>
</template>

<script>
import MyComponent from './components/TestTaxCode.vue';

export default {
  components: {
    MyComponent,
  },
};
</script>

