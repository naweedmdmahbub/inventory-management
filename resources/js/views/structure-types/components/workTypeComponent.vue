<template>
  <el-card class="box" :body-style="{ padding: '5px' }">
    <div>
      <el-form-item :label="$t('work.workType')" prop="name">
        <el-input v-model="workType.name" :disabled="mode === 'view'" />
      </el-form-item>

      <template v-for="(workTypeItem,index) in workType.workTypeItems">
        <component :is="selectedElementType"
                  :key="childKey+'-workTypeItem-'+index"
                  :workTypeItem="workTypeItem"
                  :workType="workType"
                  :units="units"
                  :structureType="structureType"
                  :mode="mode" />
      </template>
      <el-button v-if="mode !== 'view'" type="info" @click="addItem">Add Work Type Item</el-button>
      <el-button v-if="mode !== 'view'" type="danger" @click.prevent="removeWorkType(workType)">Delete</el-button>
    </div>
  </el-card>
</template>


<script>
// import WorkTypeItemComponent from './WorkTypeItemComponent';
import RodElement from './RodElement';
import BuildingElement from './BuildingElement';
import PileElement from './PileElement';
export default {
  components: { RodElement, BuildingElement, PileElement },
  props: ['structureType', 'workType', 'mode', 'selectedElementType', 'units'],
  data() {
    return {
      RodElementTypeItem: null,
      BuildingElementTypeItem: null,
      PileElementTypeItem: null,
      childKey: null,
    }
  },
  async created(){    
    this.BuildingElementTypeItem = {
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
    };
    this.RodElementTypeItem = {
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
    };
    this.PileElementTypeItem = {
        work_type_id: null,
        element_type_id: 3,
        // name: '',
        description: '',
        
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
    };
    this.childKey = this.$vnode.key;
    // console.log('workType create:', this.workType, this.structureType, this.$vnode.key);
  },
  
  methods: {
    addItem(){
      // console.log('this.BuildingElementTypeItem before adding in WorkTypeComp:', this.BuildingElementTypeItem, this.structureType);
      var elementTypeItem;
      switch (this.structureType.element_type_id){
        case 1:
          elementTypeItem = JSON.parse(JSON.stringify(this.BuildingElementTypeItem));
          this.workType.workTypeItems.push(elementTypeItem);
          console.log('addItem this.workType.workTypeItems:', elementTypeItem, this.workType.workTypeItems);
          break;
        case 2:
          elementTypeItem = JSON.parse(JSON.stringify(this.RodElementTypeItem));
          this.workType.workTypeItems.push(elementTypeItem);
          break;
        case 3:
          elementTypeItem = JSON.parse(JSON.stringify(this.PileElementTypeItem));
          this.workType.workTypeItems.push(elementTypeItem);
          break;
      }
    },
    removeWorkType(item) {
      var index = this.structureType.workTypes.indexOf(item);
      console.log('removeWorkType ', this.workType, item, item.id, index);
      this.structureType.deletedWorkTypeIDs.push(item.id);
      this.structureType.workTypes.splice(index, 1);
    },
  }
}
</script>

<style scoped>
  .box {
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
    border: .5px solid blue;
    margin: 10px;
  }
</style>
