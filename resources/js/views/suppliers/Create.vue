<template>
  <div class="app-container">
    <form-component :supplier="supplier" :mode="mode" />
  </div>
</template>

<script>
import FormComponent from './FormComponent';
export default {
  name: 'CreateSupplier',
  components: { FormComponent },
  data() {
    return {
      supplier: {
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