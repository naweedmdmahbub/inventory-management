<template>
  <div class="app-container">
    <form-component v-if="isMounted" :structureType="structureType" :mode="mode" />
  </div>
</template>

<script>
import FormComponent from './FormComponent';
import axios from 'axios';
export default {
  name: 'CreateStructureType',
  components: { FormComponent },
  data() {
    return {
      structureType: {},
      mode: 'view',
      isMounted: false,
    }
  },
  async mounted(){
    const id = this.$route.params && this.$route.params.id;
    await axios.get('/api/structureTypes/'+id)
      .then(response => {
        console.log('response:', response);
        this.structureType = response.data.data;
      });
    this.isMounted = true;
  },
}
</script>

<style>

</style>