<template>
  <div class="app-container">
    <form-component v-if="isMounted" :structure="structure" :mode="mode" />
  </div>
</template>

<script>
import FormComponent from './FormComponent';
import axios from 'axios';
export default {
  name: 'EditStructure',
  components: { FormComponent },
  data() {
    return {
      structure: {},
      mode: 'edit',
      isMounted: false,
    }
  },
  async mounted(){
    const id = this.$route.params && this.$route.params.id;
    await axios.get('/api/structures/'+id)
      .then(response => {
        console.log('response:', response);
        this.structure = response.data.data;
        this.structure.deletedWorkTypeIDs = [];
        this.structure.deletedWorkTypeItemIDs = [];
      });
    this.isMounted = true;
  },
}
</script>

<style>

</style>