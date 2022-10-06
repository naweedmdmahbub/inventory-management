<template>
  <div class="app-container">
    <form-component :project="project" :mode="mode" />
  </div>
</template>

<script>
import FormComponent from './FormComponent';
import { getCurrentDate } from '@/utils/helper.js'
export default {
  name: 'CreateProject',
  components: { FormComponent },
  data() {
    return {
      project: {
        name: '',
        client_id: '',
        code: '',
        location: '',
        description: '',
        start_date: '',
        end_date: '',
        status: '',
      },
      mode: 'create',
    }
  },
  async created(){
    this.project.start_date = await getCurrentDate();
    console.log('project create:', this.project);
  }
}
</script>

<style>

</style>