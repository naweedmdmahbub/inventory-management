<template>
  <tr>
    <td>
      <el-form-item :label="$t('work.workType')" prop="name">
        <el-input v-model="workType.name" :disabled="mode === 'view'" />
      </el-form-item>
      

      <template v-for="(workTypeItem,index) in workType.workTypeItems">
        <component :is="selectedElementType" 
                  :key="'workTypeItem-'+index"
                  :workTypeItem="workTypeItem"
                  :workType="workType"
                  :structureType="structureType"
                  :mode="mode" />
      </template>
      <el-button v-if="mode !== 'view'" type="info" @click="addItem">Add Work Type Item</el-button>

    </td>
  </tr>
</template>


<script>
import WorkTypeItemComponent from './workTypeItemComponent';
import RodElement from './RodElement';
import BuildingElement from './BuildingElement';
import PileElement from './PileElement';
export default {
  components: { WorkTypeItemComponent, RodElement, BuildingElement, PileElement },
  // props: ['structureType', 'workType', 'mode', 'selectedElement'],
  props: ['structureType', 'workType', 'mode', 'selectedElementType'],
  data() {
    return {
      RodElementTypeItem: null,
      BuildingElementTypeItem: null,
      PileElementTypeItem: null,
    }
  },
  async created(){
    
    this.RodElementTypeItem = {
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
    };
    this.BuildingElementTypeItem = {
        work_type_id: null,
        element_type_id: 2,
        name: '',
        description: '',
        nos: null,

        length: null,
        breadth: null,
        height: null,
        
        weight: null,
        quantity: null,
        total: null,
    };
    this.PileElementTypeItem = {
        work_type_id: null,
        element_type_id: 2,
        name: '',
        description: '',
        nos: null,

        length: null,
        breadth: null,
        height: null,
        
        weight: null,
        quantity: null,
        total: null,
    };
    // console.log('workType create:', this.workType, this.structureType);
  },
  
  methods: {
    addItem(){
      var elementType;
      switch (this.structureType.element_type_id){
        case 1:
          elementType = { ...this.BuildingElementTypeItem };
          this.workType.workTypeItems.push(elementType);
          break;
        case 2:
          elementType = { ...this.RodElementTypeItem };
          this.workType.workTypeItems.push(elementType);
          break;
        case 3:
          elementType = { ...this.PileElementTypeItem };
          this.workType.workTypeItems.push(elementType);
          break;
      }
      // this.workType.workTypeItems.push(item);

    },
  }
}
</script>

<style scoped>
  td {
    /* box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1); */
    border: .5px solid;
    padding: 8px;
    margin: 5px;
  }
  tr {
    margin: 5px;
  }

</style>
