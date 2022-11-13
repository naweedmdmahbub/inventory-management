<template>
  <tr>
    <td>
      <el-row :gutter="20">
          <el-col :span="11" :offset="1">
            <el-form-item :label="$t('work.workTypeItem')" prop="name">
              <el-input v-model="workTypeItem.name" :placeholder="$t('work.workTypeItem')" />
            </el-form-item>
          </el-col>
          <el-col :span="11" :offset="1">
              <el-form-item :label="$t('common.description')" prop="description">
                  <el-input v-model="workTypeItem.description" type="textarea" :placeholder="$t('common.description')" />
              </el-form-item>
          </el-col>
      </el-row>

      <el-row :gutter="20">
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.pile')" prop="pile">
                  <el-input v-model="workTypeItem.pile" :placeholder="$t('work.pile')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.pile_dia')" prop="pile_dia">
                  <el-input v-model="workTypeItem.pile_dia" :placeholder="$t('work.pile_dia')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.quantity')" prop="quantity">
                  <el-input v-model="workTypeItem.quantity" :disabled="true" :placeholder="$t('work.quantity')" />
              </el-form-item>
          </el-col>
      </el-row>

      <el-row :gutter="20">
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.bar_dia')" prop="bar_dia">
                  <el-input v-model="workTypeItem.bar_dia" :placeholder="$t('work.bar_dia')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.rebar_num')" prop="rebar_num">
                  <el-input v-model="workTypeItem.rebar_num" :placeholder="$t('work.rebar_num')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.length')" prop="length">
                  <el-input v-model="workTypeItem.length" :placeholder="$t('work.length')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
      </el-row>

      <el-row :gutter="20">
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.laping')" prop="laping">
                  <el-input v-model="workTypeItem.laping" :placeholder="$t('work.laping')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.actual_length')" prop="actual_length">
                  <el-input v-model="workTypeItem.actual_length" :placeholder="$t('work.actual_length')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.total_length')" prop="total_length">
                  <el-input v-model="workTypeItem.total_length" :placeholder="$t('work.total_length')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
      </el-row>
              
      <el-row :gutter="20">
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.unit_weight')" prop="unit_weight">
                  <el-input v-model="workTypeItem.unit_weight" :placeholder="$t('work.unit_weight')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.total_weight')" prop="total_weight">
                  <el-input v-model="workTypeItem.total_weight" :placeholder="$t('work.total_weight')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.remarks')" prop="remarks">
                  <el-input v-model="workTypeItem.remarks" :placeholder="$t('work.remarks')" @change="calculateQuantity" />
              </el-form-item>
          </el-col>
      </el-row>
      
    </td>
  </tr>
</template>


<script>
import axios from 'axios';
export default {
  props: ['structureType', 'workTypeItem', 'mode'],
  data() {
    return {
      units: [],
    }
  },
  async mounted(){
    let models = ['Unit'];
    await axios.post('/api/get-model-data', models).then(({ data }) => {
      console.log(data);
      this.units = data[0];
      console.log('mounted', this.units);
    });
  },
  async created(){
    console.log('workTypeItem create:', this.structureType);
  },
  
  methods: {
    async calculateQuantity(){
      console.log('calculateQuantity item: ', this.workTypeItem);
      let quantity = 1;
      quantity = this.workTypeItem.length ? this.workTypeItem.length * quantity : quantity;
      quantity = this.workTypeItem.breadth ? this.workTypeItem.breadth * quantity : quantity;
      quantity = this.workTypeItem.height ? this.workTypeItem.height * quantity : quantity;
      quantity = this.workTypeItem.nos ? this.workTypeItem.nos * quantity : quantity;
      this.workTypeItem.quantity = parseFloat(quantity).toFixed(6);
      // this.workTypeItem.quantity = parseFloat(this.workTypeItem.length * this.workTypeItem.breadth * this.workTypeItem.height * this.workTypeItem.nos).toFixed(6);
      console.log('calculateQuantity: ', this.workTypeItem);
    },
  }
}
</script>

<style scoped>
  td {
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
    border: .2px solid;
    padding: 8px;
    margin: 5px;
  }
</style>