<script>
    function PMT(ir, np, pv, fv, type) {
        var pmt, pvif;

        fv || (fv = 0);
        type || (type = 0);

        if (ir === 0)
            return -(pv + fv)/np;

        pvif = Math.pow(1 + ir, np);
        pmt = - ir * (pv * pvif + fv) / (pvif - 1);

        if (type === 1)
            pmt /= (1 + ir);

        return pmt;
    }

    async function cal(){
    console.log('load script async function')
    const format = (num, decimals) => num.toLocaleString('en-US', {
    minimumFractionDigits: 1,      
    maximumFractionDigits: 1,
    });

    let price_mark_value = removeComma($('input[name=x_price_mark]').val());
    console.log(price_mark_value);

    // ราคาขายเน็ตที่ต้องการ
    let price_mark = parseFloat(price_mark_value)
    console.log('price_mark = ',price_mark);

    // ถือครองมาแล้วเกิน 5 ปี หรือ มีชื่อในทะเบียนบ้านมาแล้วมากกว่า 1 ปี
    let holding_property_input =  await $('input[data-field="x_holding_property"]:checked').val();

    let holding_property = 0;
    // holding_property_input.change(function() {
    //     if(this.checked) {
    //         holding_property = 1;
    //     }
    //     else{
    //         holding_property = 0;
    //     }
    // }); 

    if(holding_property_input == '1') {
        holding_property = 1;
    }else{
        holding_property = 0;
    }

    // ค่าส่วนกลางต่อปี
    let common_fee_value = $('#x_common_fee').val();

    let commission_value = $('#x_commission').val();
    let commission_value_percent = parseFloat(commission_value) / 100;
    console.log('commission = ',commission_value_percent);


    let usable_area_value = removeComma($('#x_usable_area').val());
    let usable_area_price = 0;
    let usable_area_price_input = $('#x_usable_area_price');
    console.log("usable_area = ",usable_area_value);

    let land_size_value = removeComma($('#x_land_size').val());
    let land_size_price = 0;
    let land_size_price_input = $('#x_land_size_price');
    console.log("land_size = ",land_size_value);

    let transfer_day_expenses_with_business_tax_value = $('#x_transfer_day_expenses_with_business_tax').val();
    let transfer_day_expenses_with_business_tax_value_percent = removeComma(transfer_day_expenses_with_business_tax_value) / 100;
    console.log('transfer_with_tax = ',transfer_day_expenses_with_business_tax_value_percent);

    let transfer_day_expenses_without_business_tax_value = $('#x_transfer_day_expenses_without_business_tax').val();
    let transfer_day_expenses_without_business_tax_value_percent = removeComma(transfer_day_expenses_without_business_tax_value) / 100;
    console.log('transfer_without = ',transfer_day_expenses_without_business_tax_value_percent);

    let price_input = $('#x_price');
    let price_special_input = $('#x_price_special');
    let discount_val = removeComma($('#x_discount').val());
    console.log('discount = ',discount_val)

    let price = 0;
    let price_special = 0;

    if (holding_property == 1) {
        price = Math.ceil((price_mark/(1-transfer_day_expenses_without_business_tax_value_percent-commission_value_percent))/1000)* 1000;
    } else {
        price = Math.ceil((price_mark/(1-transfer_day_expenses_with_business_tax_value_percent-commission_value_percent))/1000)* 1000;
    }

    price_input.val(isNaN(price) ? 0 : format_num(price));

    price_special = parseFloat(price-discount_val);

    console.log("price_special = ",price_special)
    price_special_input.val(isNaN(price_special) ? 0 : format_num(price_special));

    if(usable_area_value != 0){
        usable_area_price = parseFloat(Math.ceil(price_special/usable_area_value));
        console.log("usable_area_price = ",usable_area_price)
    }
    if(land_size_value != 0){
        land_size_price = parseFloat(Math.ceil(price_special/land_size_value));
        console.log("land_size_price = ",land_size_price)
    }

    

    ///variable
    let down_price_min_a = 0;
    let average_rent_a = 0;
    let average_down_payment_a = 0;
    let monthly_expenses_a = 0;
    let down_fee = 0;
    let down_max = 0;
    let price_down_max = 0;
    let price_down_special_max = 0;
    let minimum_down_payment_max = 0;
    let down_price_max = 0;
    let monthly_expense_max = 0;
    let average_rent_max = 0;
    let average_down_payment_max = 0;
    let remaining_down = 0;
    let down_min = 0
    let credit_limit_down = 0;
    let minimum_down_payment_min = 0;
    let remaining_down_cal = 0;
    let price_down_min = 0;
    let price_down_special_min = 0;
    let down_price_min = 0;
    let remaining_credit_limit_down = 0;
    let monthly_expenses_min = 0;
    let average_rent_min = 0;
    let average_down_payment_min = 0;
    let installment_down_payment_loan = 0;
    let usable_area_price_max = 0;
    let land_size_price_max = 0;
    let usable_area_price_min = 0;
    let land_size_price_min = 0;

    

    let minimum_down_payment_model_a = parseFloat($('#x_minimum_down_payment_model_a').val());
    let reservation_price_model_a = removeComma($('#x_reservation_price_model_a').val());
    let factor_monthly_installment_over_down = parseFloat($('#x_factor_monthly_installment_over_down').val());
    let fee_a = parseFloat($('#x_fee_a').val());
    let monthly_payment_buyer = removeComma($('#x_monthly_payment_buyer').val());
    let annual_interest_buyer_model_a = parseFloat($('#x_annual_interest_buyer_model_a').val());
    let down_price_model_a = removeComma($('#x_down_price_model_a').val());
    let bank_appraisal_price = removeComma($('#x_bank_appraisal_price').val());
    let mark_up_price = parseFloat($('#x_mark_up_price').val());
    let required_gap = parseFloat($('#x_required_gap').val());
    let minimum_down_payment = parseFloat($('#x_minimum_down_payment').val());
    let discount_max = removeComma($('#x_discount_max').val());
    let reservation_price_max = removeComma($('#x_reservation_price_max').val());
    let down_price = removeComma($('#x_down_price').val());
    let fee_max = parseFloat($('#x_fee_max').val());
    let annual_interest_buyer = removeComma($('#x_annual_interest_buyer').val());
    let min_down = parseFloat($('#x_min_down').val());
    let factor_financing = parseFloat($('#x_factor_financing').val());
    let discount_min = removeComma($('#x_discount_min').val());
    let reservation_price_min = removeComma($('#x_reservation_price_min').val());
    let fee_min = parseFloat($('#x_fee_min').val());
    let monthly_payment_min = removeComma($('#x_monthly_payment_min').val());
    let annual_interest_buyer_model_min = parseFloat($('#x_annual_interest_buyer_model_min').val());
    let interest_downpayment_financing = parseFloat($('#x_interest_downpayment_financing').val());
    let monthly_payment_max = removeComma($('#x_monthly_payment_max').val());
    let factor_monthly_installment_over_down_max = parseFloat($('#x_factor_monthly_installment_over_down_max').val());
    let transfer_day_expenses_without_business_tax_max_min = parseFloat($('#x_transfer_day_expenses_without_business_tax_max_min').val());
    let transfer_day_expenses_with_business_tax_max_min = parseFloat($('#x_transfer_day_expenses_with_business_tax_max_min').val());
  
  
    console.log("----------------------------------------------------------");
    console.log("minimum_down_payment_model_a ",minimum_down_payment_model_a);
    console.log("reservation_price_model_a ",reservation_price_model_a);
    console.log("factor_monthly_installment_over_down ",factor_monthly_installment_over_down);
    console.log("fee_a ",fee_a);
    console.log("monthly_payment_buyer ",monthly_payment_buyer);
    console.log("annual_interest_buyer_model_a ",annual_interest_buyer_model_a);
    console.log("down_price_model_a ",down_price_model_a);
    console.log("bank_appraisal_price ",bank_appraisal_price);
    console.log("mark_up_price ",mark_up_price);
    console.log("required_gap ",required_gap);
    console.log("minimum_down_payment ",minimum_down_payment);
    console.log("discount_max ",discount_max);
    console.log("reservation_price_max ",reservation_price_max);
    console.log("down_price ",down_price);
    console.log("fee_max ",fee_max);
    console.log("annual_interest_buyer ",annual_interest_buyer);
    console.log("min_down ",min_down);
    console.log("factor_financing ",factor_financing);
    console.log("discount_min ",discount_min);
    console.log("reservation_price_min ",reservation_price_min);
    console.log("fee_min ",fee_min);
    console.log("monthly_payment_min ",monthly_payment_min);
    console.log("annual_interest_buyer_model_min ",annual_interest_buyer_model_min);
    console.log("interest_downpayment_financing ",interest_downpayment_financing);
    console.log("monthly_payment_max ",monthly_payment_max);
    console.log("factor_monthly_installment_over_down_max ",factor_monthly_installment_over_down_max);
    console.log("transfer_day_expenses_without_business_tax_max_min ",transfer_day_expenses_without_business_tax_max_min);
    console.log("transfer_day_expenses_with_business_tax_max_min ",transfer_day_expenses_with_business_tax_max_min);
    console.log("----------------------------------------------------------");


    let down_price_min_a_input = $('#x_down_price_min_a');
    let average_rent_a_input = $('#x_average_rent_a');
    let average_down_payment_a_input = $('#x_average_down_payment_a');
    let monthly_expenses_a_input = $('#x_monthly_expenses_a');
    let price_down_max_input = $('#x_price_down_max');
    let price_down_special_max_input = $('#x_price_down_special_max');
    let minimum_down_payment_max_input = $('#x_minimum_down_payment_max');
    let down_price_max_input = $('#x_down_price_max');
    let monthly_expense_max_input = $('#x_monthly_expense_max');
    let average_rent_max_input = $('#x_average_rent_max');
    let average_down_payment_max_input = $('#x_average_down_payment_max');
    let remaining_down_input = $('#x_remaining_down');
    let minimum_down_payment_min_input = $('#x_minimum_down_payment_min');
    let credit_limit_down_input = $('#x_credit_limit_down');
    let price_down_min_input = $('#x_price_down_min');
    let price_down_special_min_input = $('#x_price_down_special_min');
    let down_price_min_input = $('#x_down_price_min');
    let remaining_credit_limit_down_input = $('#x_remaining_credit_limit_down');
    let monthly_expenses_min_input = $('#x_monthly_expenses_min');
    let average_rent_min_input = $('#x_average_rent_min');
    let average_down_payment_min_input = $('#x_average_down_payment_min');
    let installment_down_payment_loan_input = $('#x_installment_down_payment_loan');
    let usable_area_price_max_input = $('#x_usable_area_price_max');
    let land_size_price_max_input = $('#x_land_size_price_max');
    let usable_area_price_min_input = $('#x_usable_area_price_min');
    let land_size_price_min_input = $('#x_land_size_price_min');
    


    


    



    ///Cal
    down_price_min_a = price_special * (minimum_down_payment_model_a /100) - reservation_price_model_a;
    down_fee = price_special * (fee_a/100) ;
    if(down_price_model_a <= down_price_min_a ){
        average_rent_a = Math.ceil(   price_special*((4.3/100)/(4.5/100)*(annual_interest_buyer_model_a/100))/12    );
        average_down_payment_a = Math.ceil(  (price_special-reservation_price_model_a-down_price_model_a)/1000000*monthly_payment_buyer-average_rent_a );
    }else {
        average_rent_a = Math.ceil(   (price_special-(down_price_model_a+reservation_price_model_a)*(factor_monthly_installment_over_down/100))*((4.3/100)/(4.5/100)*(annual_interest_buyer_model_a/100)/12)  );
        average_down_payment_a = Math.ceil(  ((price_special-down_price_model_a-reservation_price_model_a)*(factor_monthly_installment_over_down/100))/1000000*monthly_payment_buyer-average_rent_a );
        
    }
    monthly_expenses_a = average_rent_a + average_down_payment_a;



    if (holding_property == 1) {
        
        down_max = Math.ceil(price_mark/(1-(transfer_day_expenses_without_business_tax_max_min/100)));
    } else {
        down_max = Math.ceil(price_mark/(1-(transfer_day_expenses_with_business_tax_max_min/100)));
    }

    if(bank_appraisal_price >= mark_up_price){
        price_down_max = Math.ceil(down_max/(1-(mark_up_price/100))/1000)*1000;
    }else { 
    }
    price_down_special_max = Math.ceil((price_down_max-discount_max)/1000)*1000;

    if(usable_area_value != 0){
    usable_area_price_max = Math.ceil(price_down_special_max/usable_area_value);
    }

    if(land_size_value != 0){
    land_size_price_max = Math.ceil(price_down_special_max/land_size_value);
    }

    if(bank_appraisal_price >= down_max){
        if((bank_appraisal_price-down_max)/price_down_special_max < ((required_gap/100)-(minimum_down_payment/100))){
            down_price_max = Math.ceil((price_down_special_max*(required_gap/100)-(bank_appraisal_price-down_max))-reservation_price_max);
        }
        else {
            down_price_max = Math.ceil(price_down_special_max*(minimum_down_payment/100)-reservation_price_max);
        }
    }
    minimum_down_payment_max = format((down_price_max+reservation_price_max)/price_down_special_max*100);

    if(down_price <= down_price_max){
        average_rent_max = Math.ceil(price_down_special_max*((4.3/100)/(4.5/100)*(annual_interest_buyer/100))/12);
        average_down_payment_max = Math.ceil( (price_down_special_max-reservation_price_max-down_price_max)/1000000*monthly_payment_max-average_rent_max );
    }else { 
        average_rent_max = Math.ceil((price_down_special_max-(down_price+reservation_price_max)*(factor_monthly_installment_over_down_max/100))*((4.3/100)/(4.5/100)*(annual_interest_buyer/100)/12));      
        average_down_payment_max = Math.ceil( ((price_down_special_max-down_price-reservation_price_max)*(factor_monthly_installment_over_down_max/100))/1000000*monthly_payment_max-average_rent_max );
    }

    

    monthly_expense_max = Math.round(average_rent_max+average_down_payment_max);
    remaining_down_cal = minimum_down_payment_max-(min_down/100)*100;
    remaining_down = Math.ceil(format(minimum_down_payment_max-(min_down/100)*100));
    down_min = Math.ceil((remaining_down_cal/100)*price_down_special_max);
    minimum_down_payment_min = min_down;
    credit_limit_down = Math.round(down_min/(1-(factor_financing/100)));
    price_down_special_min = Math.ceil(price_down_special_max+(credit_limit_down-down_min));

    if(usable_area_value != 0){
        usable_area_price_min = Math.ceil(price_down_special_min/usable_area_value);
    }

    if(land_size_value != 0){
        land_size_price_min = Math.ceil(price_down_special_min/land_size_value);
    }


    price_down_min = Math.ceil(price_down_special_min + discount_min);
    down_price_min = Math.ceil( (minimum_down_payment_min/100)*price_down_special_min-reservation_price_min );
    remaining_credit_limit_down = credit_limit_down ;
    average_rent_min = Math.round( (price_down_special_min-(remaining_credit_limit_down+down_price_min+reservation_price_min))*( (4.3/100)/(4.5/100)*(annual_interest_buyer_model_min/100)/12) );
    average_down_payment_min = Math.round( (price_down_special_min-down_price_min-remaining_credit_limit_down-reservation_price_min)/1000000*monthly_payment_min-average_rent_min );
    installment_down_payment_loan = Math.round(PMT((interest_downpayment_financing/100)/12,36,-remaining_credit_limit_down,0,0));
    monthly_expenses_min = Math.round(average_rent_min+average_down_payment_min+installment_down_payment_loan);

    //showInput
    down_price_min_a_input.val(isNaN(down_price_min_a) ? 0 : format_num(down_price_min_a ));
    average_rent_a_input.val(isNaN(average_rent_a) ? 0 : format_num(average_rent_a));
    average_down_payment_a_input.val(isNaN(average_down_payment_a) ? 0 : format_num(average_down_payment_a));
    monthly_expenses_a_input.val(isNaN(monthly_expenses_a) ? 0 : format_num(monthly_expenses_a ));
    price_down_max_input.val(isNaN(price_down_max) ? 0 : format_num(price_down_max));
    price_down_special_max_input.val(isNaN(price_down_special_max) ? 0 : format_num(price_down_special_max));
    down_price_max_input.val(isNaN(down_price_max) ? 0 : format_num(down_price_max));
    minimum_down_payment_max_input.val(isNaN(minimum_down_payment_max) ? 0 : format_num(minimum_down_payment_max));
    average_rent_max_input.val(isNaN(average_rent_max) ? 0 : format_num(average_rent_max));
    average_down_payment_max_input.val(isNaN(average_down_payment_max) ? 0 : format_num(average_down_payment_max));
    monthly_expense_max_input.val(isNaN(monthly_expense_max) ? 0 : format_num(monthly_expense_max));
    remaining_down_input.val(isNaN(remaining_down) ? 0 : format_num(remaining_down));
    minimum_down_payment_min_input.val(isNaN(minimum_down_payment_min) ? 0 : format_num(minimum_down_payment_min));
    credit_limit_down_input.val(isNaN(credit_limit_down) ? 0 : format_num(credit_limit_down));
    price_down_min_input.val(isNaN(price_down_min) ? 0 : format_num(price_down_min));
    price_down_special_min_input.val(isNaN(price_down_special_min) ? 0 : format_num(price_down_special_min));
    down_price_min_input.val(isNaN(down_price_min) ? 0 : format_num(down_price_min));
    remaining_credit_limit_down_input.val(isNaN(remaining_credit_limit_down) ? 0 : format_num(remaining_credit_limit_down));
    monthly_expenses_min_input.val(isNaN(monthly_expenses_min) ? 0 : format_num(monthly_expenses_min));
    average_rent_min_input.val(isNaN(average_rent_min) ? 0 : format_num(average_rent_min));
    average_down_payment_min_input.val(isNaN(average_down_payment_min) ? 0 : format_num(average_down_payment_min));
    installment_down_payment_loan_input.val(isNaN(installment_down_payment_loan) ? 0 : format_num(installment_down_payment_loan));
    usable_area_price_max_input.val(isNaN(usable_area_price_max) ? 0 : format_num(usable_area_price_max));
    land_size_price_max_input.val(isNaN(land_size_price_max) ? 0 : format_num(land_size_price_max));
    usable_area_price_min_input.val(isNaN(usable_area_price_min) ? 0 : format_num(usable_area_price_min));
    land_size_price_min_input.val(isNaN(land_size_price_min) ? 0 : format_num(land_size_price_min));
    land_size_price_input.val(isNaN(land_size_price) ? 0 : format_num(land_size_price));
    usable_area_price_input.val(isNaN(usable_area_price) ? 0 : format_num(usable_area_price ));
    
   
} 



</script>
