<template>
  <div class="app-container">
    <form-component v-if="isMounted" :subcontractor="subcontractor" :mode="mode" />
  </div>
</template>

<script>
import FormComponent from './FormComponent';
import axios from 'axios';
export default {
  name: 'CreateSubcontractor',
  components: { FormComponent },
  data() {
    return {
      subcontractor: {},
      mode: 'view',
      isMounted: false,
    }
  },
  async mounted(){
    const id = this.$route.params && this.$route.params.id;
    await axios.get('/api/subcontractors/'+id)
      .then(response => {
        console.log('response:', response);
        this.subcontractor = response.data.data;
      });
    this.isMounted = true;
  },
}
</script>

<style>

</style>