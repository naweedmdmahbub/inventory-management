<template>
  <el-card class="box" :body-style="{ padding: '5px' }">
    <div>
      <el-form-item :label="$t('work.work')" prop="name">
        <el-input v-model="work.name" :disabled="mode === 'view'" />
      </el-form-item>

      <template v-for="(workItem,index) in work.workItems">
        <component :is="selectedElementType"
                  :key="childKey+'-workItem-'+index"
                  :workItem="workItem"
                  :work="work"
                  :units="units"
                  :structure="structure"
                  :mode="mode" />
      </template>
      <el-button v-if="mode !== 'view'" type="info" @click="addItem">Add Work Type Item</el-button>
      <el-button v-if="mode !== 'view'" type="danger" @click.prevent="removeWorkType(work)">Delete</el-button>
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
  props: ['structure', 'work', 'mode', 'selectedElementType', 'units'],
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
    };
    this.RodElementTypeItem = {
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
    };
    this.PileElementTypeItem = {
        work_id: null,
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
    // console.log('work create:', this.work, this.structure, this.$vnode.key);
  },
  
  methods: {
    addItem(){
      // console.log('this.BuildingElementTypeItem before adding in WorkTypeComp:', this.BuildingElementTypeItem, this.structure);
      var elementTypeItem;
      switch (this.structure.element_type_id){
        case 1:
          elementTypeItem = JSON.parse(JSON.stringify(this.BuildingElementTypeItem));
          this.work.workItems.push(elementTypeItem);
          console.log('addItem this.work.workItems:', elementTypeItem, this.work.workItems);
          break;
        case 2:
          elementTypeItem = JSON.parse(JSON.stringify(this.RodElementTypeItem));
          this.work.workItems.push(elementTypeItem);
          break;
        case 3:
          elementTypeItem = JSON.parse(JSON.stringify(this.PileElementTypeItem));
          this.work.workItems.push(elementTypeItem);
          break;
      }
    },
    removeWorkType(item) {
      var index = this.structure.works.indexOf(item);
      console.log('removeWorkType ', this.work, item, item.id, index);
      this.structure.deletedWorkTypeIDs.push(item.id);
      this.structure.works.splice(index, 1);
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
