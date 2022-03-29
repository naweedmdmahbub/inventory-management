<template>
  <div class="app-container">
    <form-component :subcontractor="subcontractor" :mode="mode" />
  </div>
</template>

<script>
import FormComponent from './FormComponent';
export default {
  name: 'CreateSubcontractor',
  components: { FormComponent },
  data() {
    return {
      subcontractor: {
        first_name: '',
        last_name: '',
        business_name: '',
        email: '',
        contact_person: '',
        contact_no: '',
        address: '',
      },
      mode: 'create',
    }
  }
}
</script>

<style>

</style>