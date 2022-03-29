<template>
  <div class="app-container">
    <form-component v-if="isMounted" :supplier="supplier" :mode="mode" />
  </div>
</template>

<script>
import FormComponent from './FormComponent';
import axios from 'axios';
export default {
  name: 'CreateSupplier',
  components: { FormComponent },
  data() {
    return {
      supplier: {},
      mode: 'view',
      isMounted: false,
    }
  },
  async mounted(){
    const id = this.$route.params && this.$route.params.id;
    await axios.get('/api/suppliers/'+id)
      .then(response => {
        console.log('response:', response);
        this.supplier = response.data.data;
      });
    this.isMounted = true;
  },
}
</script>

<style>

</style>