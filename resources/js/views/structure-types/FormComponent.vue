<template>
  <div class="form-container">
    <el-form
      ref="structureTypeForm"
      :model="structureType"
      label-position="left"
      label-width="150px"
    >
      <el-form-item :label="$t('common.name')" prop="name">
        <el-input v-model="structureType.name" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('common.description')" prop="description">
        <el-input v-model="structureType.description" :disabled="mode === 'view'" />
      </el-form-item>

      <template v-for="(workType, index) in structureType.workTypes">
        <work-type-component :key="'workType-'+index"
          :structureType="structureType"
          :workType="workType"
          :mode="mode"
        />
      </template>
      <el-button v-if="mode !== 'view'" type="primary" @click="addItem">Add Work Type</el-button>
      

      <el-form-item>
        <el-button v-if="mode === 'create'" type="primary" @click="handleSubmit">Create</el-button>
        <el-button v-if="mode === 'edit'" type="primary" @click="handleSubmit">Update</el-button>
        <el-button @click="cancelled">Cancel</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import WorkTypeComponent from './components/workTypeComponent';
import axios from 'axios';
import { showErrors } from '@/utils/helper.js'
export default {
  name: 'StructureTypeForm',
  components: { WorkTypeComponent },
  props: ['structureType', 'mode'],
  data() {
    return {
      selectedUnitID: null,
      units: [],
    }
  },
  async mounted(){
  },
  async created(){
    console.log('structureType create:', this.structureType);
  },
  
  methods: {
    cancelled(){
      this.$router.push('/project/structure-types');
    },
    async handleSubmit() {
      console.log('handleSubmit:', this.structureType)
      this.structureType.unit_id = this.selectedUnitID;
      if (this.structureType.id !== undefined) {
        this.structureType.status = 'active';
        axios
          .put('api/structureTypes/'+this.structureType.id, this.structureType)
          .then(response => {
            this.$router.push('/project/structure-types');
            this.$message({
              type: 'success',
              message: 'StructureType info has been updated successfully',
              duration: 5 * 1000,
            });
          })
          .catch(error => {
            console.log('error:', error);
            showErrors(error);
          });
      } else {
        axios
          .post('api/structureTypes', this.structureType)
          .then(response => {
            this.$router.push('/project/structure-types');
            this.$message({
              message: 'New structureType ' + this.structureType.name + ' ' + this.structureType.code + ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
          })
          .catch(error => {
            showErrors(error);
          });
      }
    },
    addItem(){
      var item = {
          name: '',
          structure_type_id: null,
          workTypeItems: [{
            work_type_id: null,
            unit_id: null,
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
      };
      this.structureType.workTypes.push(item);

    },
  }
}
</script>

<style scoped>
input, select{
  width:100%;
  box-sizing:border-box;
}
</style>