<template>
  <div class="app-container">
    <form-component v-if="isMounted" :client="client" :mode="mode" />
  </div>
</template>

<script>
import FormComponent from './FormComponent';
import axios from 'axios';
export default {
  name: 'CreateClient',
  components: { FormComponent },
  data() {
    return {
      client: {},
      mode: 'view',
      isMounted: false,
    }
  },
  async mounted(){
    const id = this.$route.params && this.$route.params.id;
    await axios.get('/api/clients/'+id)
      .then(response => {
        console.log('response:', response);
        this.client = response.data.data;
      });
    this.isMounted = true;
  },
}
</script>

<style>

</style>