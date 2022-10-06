<template>
  <div class="app-container">
    <form-component v-if="isMounted" :project="project" :mode="mode" />
  </div>
</template>

<script>
import FormComponent from './FormComponent';
import axios from 'axios';
export default {
  name: 'CreateProject',
  components: { FormComponent },
  data() {
    return {
      project: {},
      mode: 'edit',
      isMounted: false,
    }
  },
  async mounted(){
    const id = this.$route.params && this.$route.params.id;
    await axios.get('/api/projects/'+id)
      .then(response => {
        console.log('response:', response);
        this.project = response.data.data;
      });
    this.isMounted = true;
  },
}
</script>

<style>

</style>