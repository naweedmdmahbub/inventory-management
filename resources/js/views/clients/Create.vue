<template>
  <div class="app-container">
    <form-component :client="client" mode="create" />
  </div>
</template>

<script>
import FormComponent from './FormComponent';
export default {
  name: 'CreateClient',
  components: { FormComponent },
  data() {
    return {
      client: {
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