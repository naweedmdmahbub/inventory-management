<template>
  <tr>
    <td>
      <el-form-item :label="$t('work.workType')" prop="name">
        <el-input v-model="workType.name" :disabled="mode === 'view'" />
      </el-form-item>
      <template v-for="(workTypeItem,index) in workType.workTypeItems">
        <work-type-item-component :key="'workTypeItem-'+index"
                      :workTypeItem="workTypeItem"
                      :workType="workType"
                      :structureType="structureType"
                      :mode="mode"
        />
      </template>
      <el-button v-if="mode !== 'view'" type="info" @click="addItem">Add Work Type Items</el-button>

    </td>
  </tr>
</template>


<script>
import WorkTypeItemComponent from './workTypeItemComponent';
export default {
  components: { WorkTypeItemComponent },
  props: ['structureType', 'workType', 'mode'],
  data() {
    return {
      
    }
  },
  async mounted(){
  },
  async created(){
    console.log('workType create:', this.workType, this.structureType);
  },
  
  methods: {
    addItem(){
      var item = {
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
      };
      this.workType.workTypeItems.push(item);

    },
  }
}
</script>

<style scoped>
  td {
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
    border: .5px solid;
    padding: 8px;
    margin: 5px;
  }

</style>
