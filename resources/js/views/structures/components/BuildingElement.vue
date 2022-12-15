<template>
    <div class="box-element">
      <el-row :gutter="5">
          <el-col :span="15" :offset="1">
              <el-form-item :label="$t('common.description')" prop="description">
                  <el-input v-model="workItem.description" type="textarea" :placeholder="$t('common.description')" :disabled="mode === 'view'" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
            <el-form-item :label="$t('common.unit_id')" prop="unit_id">
              <el-select v-model="workItem.unit_id" placeholder="Please Select Unit" :disabled="mode === 'view'" width="100%">
                  <el-option v-for="unit in units"
                            :key="unit.id"
                            :label="unit.name"
                            :value="unit.id" />
              </el-select>
            </el-form-item>
          </el-col>
      </el-row>

      <el-row :gutter="5">
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.length')" prop="length">
                  <el-input v-model="workItem.length" :placeholder="$t('work.length')" :disabled="mode === 'view'" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.breadth')" prop="breadth">
                  <el-input v-model="workItem.breadth" :placeholder="$t('work.breadth')" :disabled="mode === 'view'" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.height')" prop="height">
                  <el-input v-model="workItem.height" :placeholder="$t('work.height')" :disabled="mode === 'view'" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
      </el-row>

              
      <el-row :gutter="5">
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.nos')" prop="nos">
                  <el-input v-model="workItem.nos" :placeholder="$t('work.nos')" :disabled="mode === 'view'" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.quantity')" prop="quantity">
                  <el-input v-model="workItem.quantity" :disabled="true" :placeholder="$t('work.quantity')" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item>
                <el-button v-if="mode !== 'view'" type="danger" @click.prevent="removeBuildingElement(workItem)">Delete</el-button>
              </el-form-item>
          </el-col>
      </el-row>
      
    </div>
</template>


<script>
export default {
  props: ['structure', 'workItem', 'mode', 'work', 'units'],
  data() {
    return {
      // units: [],
    }
  },
  async mounted(){
  },
  async created(){
    // console.log('workItem create:', this.structure, this.workItem);
  },
  
  methods: {
    async calculateQuantity(){
      let quantity = 1;
      quantity = this.workItem.length ? this.workItem.length * quantity : quantity;
      quantity = this.workItem.breadth ? this.workItem.breadth * quantity : quantity;
      quantity = this.workItem.height ? this.workItem.height * quantity : quantity;
      quantity = this.workItem.nos ? this.workItem.nos * quantity : quantity;
      this.workItem.quantity = parseFloat(quantity).toFixed(6);
      // console.log('calculateQuantity: ', this.workItem);
    },
    removeBuildingElement(item) {
      var index = this.work.workItems.indexOf(item);
      console.log('removeBuildingElement: ', this.work, item, item.id, index, this.structure.deletedWorkTypeItemIDs);
      this.structure.deletedWorkTypeItemIDs.push(item.id);
      this.work.workItems.splice(index, 1);
    },
  }
}
</script>

<style scoped>
  .box-element {
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
    border: .2px solid aqua;
    padding: 2px;
    margin: 2px;
  }
</style>