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
            element_type_id: 1,
            workTypeItems: [{
              work_type_id: null,
              element_type_id: 1,
              name: '',
              description: '',

              dia: 10,
              rod_length: 1,
              lap: 0,
              matam: 0,
              cutting_length: 1,
              nos: 1,
              layer: 1,
              item: 1,
              total_length: null,
              unit_weight: null,
              weight: null,
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