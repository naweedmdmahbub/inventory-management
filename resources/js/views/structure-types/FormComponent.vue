<template>
  <div class="form-container">
    <el-form
      ref="structureTypeForm"
      :model="structureType"
      label-width="120px"
    >
      <el-form-item :label="$t('common.name')" prop="name">
        <el-input v-model="structureType.name" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('common.description')" prop="description">
        <el-input v-model="structureType.description" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('work.element')" prop="element_type_id">
        <el-select v-model="structureType.element_type_id" placeholder="Please Select Element"
                  :disabled="mode === 'view'" width="100%" @change="changeElementTypeID">
            <el-option v-for="element in elements"
                      :key="element.id"
                      :label="element.name"
                      :value="element.id" />
        </el-select>
      </el-form-item>

      <template v-for="(workType, index) in structureType.workTypes">
        <work-type-component v-if="isMounted"
          :key="'workType-'+index"
          :structureType="structureType"
          :workType="workType"
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
  props: ['structureType', 'mode'],
  data() {
    return {
      selectedElementType: 'BuildingElement',
      selectedElementTypeID: null,
      RodElementType: null,
      BuildingElementType: null,
      PileElementType: null,
      elements: [],
      isMounted: false,
    }
  },
  async mounted(){
    var models = ['ElementType'];
    await axios.post('/api/get-model-data', models).then(({ data }) => {
      // console.log(data);
      this.elements = data[0];
      this.isMounted = true;
      // console.log('FormComponent mounted', this.elements, this.isMounted);
    });
  },
  async created(){
    this.BuildingElementType = {
        name: '',
        structure_type_id: null,
        workTypeItems: [{
          work_type_id: null,
          element_type_id: 1,
          // name: '',
          description: '',
          nos: null,

          length: null,
          breadth: null,
          height: null,

          unit_id: null,
          quantity: null,
          total: null,
        }]
    };
    this.RodElementType = {
        name: '',
        structure_type_id: null,
        total: null,
        workTypeItems: [{
          work_type_id: null,
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
        workTypeItems: [{
          work_type_id: null,
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
    // console.log('structureType create:', this.structureType);
  },
  
  methods: {
    cancelled(){
      this.$router.push('/project/structure-types');
    },
    async handleSubmit() {
      console.log('handleSubmit:', this.structureType)
      // this.structureType.element_type_id = this.selectedElementTypeID;
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
      var obj;
      switch (this.structureType.element_type_id){
        case 1:
          obj = JSON.parse(JSON.stringify(this.BuildingElementType));
          this.structureType.workTypes.push(obj);
          this.selectedElementType = 'BuildingElement';
          break;
        case 2:
          obj = JSON.parse(JSON.stringify(this.RodElementType));
          this.structureType.workTypes.push(obj);
          this.selectedElementType = 'RodElement';
          break;
        case 3:
          obj = JSON.parse(JSON.stringify(this.PileElementType));
          this.structureType.workTypes.push(obj);
          this.selectedElementType = 'PileElement';
          break;
      }
    },
    changeElementTypeID(){
      this.structureType.workTypes = [];
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