<template>
  <div>
    <div class="box">
      <el-row :gutter="20">
          <el-col :span="23" :offset="1">
              <el-form-item :label="$t('common.description')" prop="description">
                  <el-input v-model="workItem.description" type="textarea" :placeholder="$t('common.description')" />
              </el-form-item>
          </el-col>
      </el-row>

      <el-row :gutter="20">
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.pile')" prop="pile">
                  <el-input v-model="workItem.pile" :placeholder="$t('work.pile')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.pile_dia')" prop="pile_dia">
                  <el-input v-model="workItem.pile_dia" :placeholder="$t('work.pile_dia')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.quantity')" prop="quantity">
                  <el-input v-model="workItem.quantity" :disabled="true" :placeholder="$t('work.quantity')" />
              </el-form-item>
          </el-col>
      </el-row>

      <el-row :gutter="20">
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.bar_dia')" prop="bar_dia">
                  <el-input v-model="workItem.bar_dia" :placeholder="$t('work.bar_dia')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.rebar_num')" prop="rebar_num">
                  <el-input v-model="workItem.rebar_num" :placeholder="$t('work.rebar_num')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.length')" prop="length">
                  <el-input v-model="workItem.length" :placeholder="$t('work.length')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
      </el-row>

      <el-row :gutter="20">
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.laping')" prop="laping">
                  <el-input v-model="workItem.laping" :placeholder="$t('work.laping')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.actual_length')" prop="actual_length">
                  <el-input v-model="workItem.actual_length" :placeholder="$t('work.actual_length')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.total_length')" prop="total_length">
                  <el-input v-model="workItem.total_length" :placeholder="$t('work.total_length')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
      </el-row>
              
      <el-row :gutter="20">
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.unit_weight')" prop="unit_weight">
                  <el-input v-model="workItem.unit_weight" :placeholder="$t('work.unit_weight')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.total_weight')" prop="total_weight">
                  <el-input v-model="workItem.total_weight" :placeholder="$t('work.total_weight')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.remarks')" prop="remarks">
                  <el-input v-model="workItem.remarks" :placeholder="$t('work.remarks')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
      </el-row>
      
    </div>
  </div>
</template>


<script>
export default {
  props: ['structure', 'workItem', 'mode', 'units'],
  data() {
    return {}
  },
  async mounted(){},
  async created(){
    console.log('Pile workItem create:', this.structure);
  },
  
  methods: {
    async calculateQuantity(){
      console.log('calculateQuantity item: ', this.workItem);
      let quantity = 1;
      quantity = this.workItem.length ? this.workItem.length * quantity : quantity;
      quantity = this.workItem.breadth ? this.workItem.breadth * quantity : quantity;
      quantity = this.workItem.height ? this.workItem.height * quantity : quantity;
      quantity = this.workItem.nos ? this.workItem.nos * quantity : quantity;
      this.workItem.quantity = parseFloat(quantity).toFixed(6);
      // this.workItem.quantity = parseFloat(this.workItem.length * this.workItem.breadth * this.workItem.height * this.workItem.nos).toFixed(6);
      console.log('calculateQuantity: ', this.workItem);
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