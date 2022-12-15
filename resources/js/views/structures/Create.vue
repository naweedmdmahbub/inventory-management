<template>
  <div class="app-container">
    <form-component :structure="structure" :mode="mode" />
  </div>
</template>

<script>
import FormComponent from './FormComponent';
export default {
  name: 'CreateStructureType',
  components: { FormComponent },
  data() {
    return {
      structure: {
        name: '',
        description: '',
        element_type_id: 1,
        works: [{
          name: '',
          structure_type_id: null,
          total: null,
          workItems: [{
            work_id: null,
            element_type_id: 1,
            // name: '',
            description: '',
            nos: null,

            length: null,
            breadth: null,
            height: null,
            
            weight: null,
            quantity: null,
            total: null,
          }]
        }],
      },
      mode: 'create',
    }
  },
}
</script>

<style>

</style>