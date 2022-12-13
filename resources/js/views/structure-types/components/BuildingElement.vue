<template>
    <div class="box">
      <el-row :gutter="5">
          <el-col :span="15" :offset="1">
              <el-form-item :label="$t('common.description')" prop="description">
                  <el-input v-model="workTypeItem.description" type="textarea" :placeholder="$t('common.description')" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
            <el-form-item :label="$t('common.unit_id')" prop="unit_id">
              <el-select v-model="workTypeItem.unit_id" placeholder="Please Select Unit" :disabled="mode === 'view'" width="100%">
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
                  <el-input v-model="workTypeItem.length" :placeholder="$t('work.length')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.breadth')" prop="breadth">
                  <el-input v-model="workTypeItem.breadth" :placeholder="$t('work.breadth')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.height')" prop="height">
                  <el-input v-model="workTypeItem.height" :placeholder="$t('work.height')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
      </el-row>

              
      <el-row :gutter="5">
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.nos')" prop="nos">
                  <el-input v-model="workTypeItem.nos" :placeholder="$t('work.nos')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.quantity')" prop="quantity">
                  <el-input v-model="workTypeItem.quantity" :disabled="true" :placeholder="$t('work.quantity')" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item>
                <el-button type="danger" @click.prevent="removeBuildingElement(workTypeItem)">Delete</el-button>
              </el-form-item>
          </el-col>
      </el-row>
      
    </div>
</template>


<script>
export default {
  props: ['structureType', 'workTypeItem', 'mode', 'workType', 'units'],
  data() {
    return {
      // units: [],
    }
  },
  async mounted(){
  },
  async created(){
    // console.log('workTypeItem create:', this.structureType, this.workTypeItem);
  },
  
  methods: {
    async calculateQuantity(){
      let quantity = 1;
      quantity = this.workTypeItem.length ? this.workTypeItem.length * quantity : quantity;
      quantity = this.workTypeItem.breadth ? this.workTypeItem.breadth * quantity : quantity;
      quantity = this.workTypeItem.height ? this.workTypeItem.height * quantity : quantity;
      quantity = this.workTypeItem.nos ? this.workTypeItem.nos * quantity : quantity;
      this.workTypeItem.quantity = parseFloat(quantity).toFixed(6);
      // console.log('calculateQuantity: ', this.workTypeItem);
    },
    removeBuildingElement(item) {
      var index = this.workType.workTypeItems.indexOf(item);
      console.log('removeBuildingElement: ', this.workType, item, index);
      this.workType.workTypeItems.splice(index, 1);
    },
  }
}
</script>

<style scoped>
  .box {
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
    border: .2px solid;
    padding: 2px;
    margin: 2px;
  }
</style>