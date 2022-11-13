<template>
  <div class="app-container">
    <form-component :structureType="structureType" :mode="mode" />
  </div>
</template>

<script>
import FormComponent from './FormComponent';
export default {
  name: 'CreateStructureType',
  components: { FormComponent },
  data() {
    return {
      structureType: {
        name: '',
        description: '',
        element_type_id: 1,
        workTypes: [{
          name: '',
          structure_type_id: null,
          total: null,
          workTypeItems: [{
            work_type_id: null,
            element_type_id: 1,
            name: '',
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