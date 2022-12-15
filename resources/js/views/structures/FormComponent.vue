<template>
  <div class="form-container">
    <el-form
      ref="structureForm"
      :model="structure"
      label-width="120px"
    >
      <el-form-item :label="$t('common.name')" prop="name">
        <el-input v-model="structure.name" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('common.description')" prop="description">
        <el-input v-model="structure.description" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('work.element')" prop="element_type_id">
        <el-select v-model="structure.element_type_id" placeholder="Please Select Element"
                  :disabled="mode !== 'create'" width="100%" @change="changeElementTypeID">
            <el-option v-for="element in elements"
                      :key="element.id"
                      :label="element.name"
                      :value="element.id" />
        </el-select>
      </el-form-item>

      <template v-for="(work, index) in structure.works">
        <work-type-component v-if="isMounted"
          :key="'work-'+index"
          :structure="structure"
          :work="work"
          :units="units"
          :mode="mode"
          :selectedElementType="selectedElementType"
        />
      </template>


      <el-button v-if="mode !== 'view'" type="info" @click="addItem">Add Work Type</el-button>
      

      <el-form-item>
        <el-button v-if="mode === 'create'" type="primary" @click="handleSubmit">Create</el-button>
        <el-button v-if="mode === 'edit'" type="primary" @click="handleSubmit">Update</el-button>
        <el-button @click="cancelled">Cancel</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import WorkTypeComponent from './components/WorkTypeComponent';
import axios from 'axios';
import { showErrors } from '@/utils/helper.js'
export default {
  name: 'StructureTypeForm',
  components: { WorkTypeComponent },
  props: ['structure', 'mode'],
  data() {
    return {
      selectedElementType: 'BuildingElement',
      RodElementType: null,
      BuildingElementType: null,
      PileElementType: null,
      elements: [],
      units: [],
      isMounted: false,
    }
  },
  async mounted(){
    var models = ['ElementType', 'Unit'];
    await axios.post('/api/get-model-data', models).then(({ data }) => {
      // console.log(data);
      this.elements = data[0];
      this.units = data[1];
      this.isMounted = true;
      // console.log('FormComponent mounted', this.elements, this.isMounted);
    });
  },
  async created(){
    this.BuildingElementType = {
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

          unit_id: null,
          quantity: null,
        }]
    };
    this.RodElementType = {
        name: '',
        structure_type_id: null,
        total: null,
        workItems: [{
          work_id: null,
          element_type_id: 2,
          // name: '',
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
    };
    this.PileElementType = {
        name: '',
        structure_type_id: null,
        total: null,
        workItems: [{
          work_id: null,
          element_type_id: 3,
          // name: '',
          
          pile: null,
          pile_dia: null,
          quantity: null,
          bar_dia: null,
          rebar_num: null,
          length: null,
          laping: null,
          actual_length: null,
          total_length: null,
          unit_weight: null,
          total_weight: null,
          remarks: null,
        }]
    };
    // console.log('structure create:', this.structure);
  },
  
  methods: {
    cancelled(){
      this.$router.push('/project/structures');
    },

    async handleSubmit() {
      if(this.mode === 'edit' && (this.structure.deletedWorkTypeIDs.length>0 || this.structure.deletedWorkTypeItemIDs>0) ) {
          this.$confirm('While updating do you want to delete items?', 'Warning', {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel Update',
            type: 'warning',
            center: true
          }).then(() => {
            this.saveStructureType();
          }).catch(() => {
            this.$message({
              type: 'info',
              message: 'Delete canceled'
            });
          });
      } else {
          this.saveStructureType();
          console.log('handleSubmit:', this.structure);        
      }
    },
    saveStructureType(){
      if (this.structure.id !== undefined) {
        this.structure.status = 'active';
        axios
          .put('api/structures/'+this.structure.id, this.structure)
          .then(response => {
            this.$router.push('/project/structures');
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
          .post('api/structures', this.structure)
          .then(response => {
            this.$router.push('/project/structures');
            this.$message({
              message: 'New structure ' + this.structure.name + ' ' + this.structure.code + ' has been created successfully.',
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
      var obj;
      switch (this.structure.element_type_id){
        case 1:
          obj = JSON.parse(JSON.stringify(this.BuildingElementType));
          this.structure.works.push(obj);
          this.selectedElementType = 'BuildingElement';
          break;
        case 2:
          obj = JSON.parse(JSON.stringify(this.RodElementType));
          this.structure.works.push(obj);
          this.selectedElementType = 'RodElement';
          break;
        case 3:
          obj = JSON.parse(JSON.stringify(this.PileElementType));
          this.structure.works.push(obj);
          this.selectedElementType = 'PileElement';
          break;
      }
    },
    changeElementTypeID(){
      this.structure.works = [];
      this.addItem();
      console.log('changeElementTypeID', this);
    },
  },
}
</script>

<style scoped>
input, select{
  width:100%;
  box-sizing:border-box;
}
</style>