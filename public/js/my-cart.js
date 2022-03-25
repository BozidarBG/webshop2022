class BaseCart{
    constructor() {
        this.initiateBaseCartProps();
        this.getStorageContent();
        this.showCartQuantityInNav();
        //console.log(this)
    }

    initiateBaseCartProps(){
        this.storage="aroma_cart";
        this.cart_items=[];
        this.cart_qty=0;
        this.subtotal=0;
        this.subtotal_with_coupon=0;
        this.total=0;
        this.minimum_for_shipping=500000;
        this.shipping_fee=0;
        this.coupon={};
        this.coupon_is_applied=false;
    }

    showCartQuantityInNav(){
        this.getStorageContent();
        document.getElementsByClassName('nav-shop__custom-circle')[0].textContent=this.cart_qty;
    }

    showModalMessage(message, css_class, duration=3000){
        let modal=document.getElementsByClassName('toast_container')[0];
        let span=modal.querySelector('span');
        span.textContent=message;
        modal.classList.add(css_class);
        modal.classList.remove('d-none');
        setTimeout(()=>{
            span.textContent="";
            modal.classList.remove(css_class);
            modal.classList.add('d-none');
        }, duration);
    }

    clearStorage(){
        localStorage.removeItem(this.storage);
    }


    getStorageContent(){
        let content=JSON.parse(localStorage.getItem(this.storage));
        if(content){
            this.cart_items=content.cart_items;
            this.coupon=content.coupon;
            this.coupon_is_applied=content.coupon_is_applied;
            this.subtotal=content.subtotal;
            this.subtotal_with_coupon=content.subtotal_with_coupon;
            this.shipping_fee=content.shipping_fee;
            this.total=content.total;
            this.cart_qty=content.cart_qty;
            this.minimum_for_shipping=content.minimum_for_shipping;
        }

    }

    setStorageContent(){
        let content={};
        content.coupon=this.coupon;
        content.coupon_is_applied=this.coupon_is_applied;
        content.cart_items=this.cart_items;
        content.subtotal=this.subtotal;
        content.subtotal_with_coupon=this.subtotal_with_coupon;
        content.shipping_fee=this.shipping_fee;
        content.minimum_for_shipping=this.minimum_for_shipping;
        content.total=this.total;
        content.cart_qty=this.cart_qty;
        //console.log(content)
        localStorage.setItem(this.storage, JSON.stringify(content));
    }

    collectData(tag, qty=1) {
        let product={};
        product.id = tag.getAttribute('data-id');
        product.name = tag.getAttribute('data-name');
        product.slug = tag.getAttribute('data-slug');
        product.acc_code = tag.getAttribute('data-acc_code');
        product.stock = parseInt(tag.getAttribute('data-stock'));
        product.regular_price = parseInt(tag.getAttribute('data-regular_price'));
        product.action_price = parseInt(tag.getAttribute('data-action_price'));
        product.selling_price=product.action_price > 0 ? product.action_price : product.regular_price;
        product.image = tag.getAttribute('data-image');
        product.qty=parseInt(qty);
        product.subtotal=product.qty*product.selling_price;
        //if this product is already in cart, show message that product is already in cart
        let product_is_in_cart=false;
        //console.log(this.cart_items)
        if(this.cart_items.length){
            this.cart_items.forEach((cart_item)=>{
                if(product.id==cart_item.id){
                    this.showModalMessage('This item is already in the cart', 'bg-danger');
                    product_is_in_cart=true;
                }
            });
        }
        if(!product_is_in_cart){
            this.cart_items.push(product);
            this.cart_qty +=product.qty;
            this.setStorageContent();
            this.showModalMessage('Item added to the cart', 'bg-success');
            this.showCartQuantityInNav();
        }

    }

    //must be called whenever there is a change in this.cart_items (item removed, qty increased od decreased)
    calculateTotalsAndCartQty(){
        this.subtotal=0;
        this.cart_qty=0;
        this.cart_items.forEach((item, index)=>{
            this.subtotal +=item.subtotal;
            this.cart_qty +=item.qty;
        });

        this.subtotal_with_coupon=0;
        if(this.coupon && this.coupon_is_applied){
            if(this.subtotal/100 >= this.coupon.cart_value){
                if(this.coupon.type==="fixed"){
                    this.subtotal_with_coupon=this.subtotal-this.coupon.value*100;
                }else if(this.coupon.type==='percent'){
                    this.subtotal_with_coupon=this.subtotal/100*(100-this.coupon.value);
                }
            }else{
                this.subtotal_with_coupon=0;
                this.showModalMessage("Cart value must be over "+this.formatPrice(this.coupon.cart_value*100)+" RSD in order to use this coupon", 'bg-warning', 5000);
            }
        }

        if(this.subtotal_with_coupon && this.subtotal_with_coupon>=this.minimum_for_shipping){
            this.shipping_fee=0;
        }else if(this.subtotal>=this.minimum_for_shipping){
            this.shipping_fee=0;
        }else{
            this.shipping_fee=100000;
        }

        if(this.subtotal===0){
            this.shipping_fee=0;
        }

        this.total=this.subtotal_with_coupon ? this.shipping_fee+this.subtotal_with_coupon : this.shipping_fee+this.subtotal;
        this.setStorageContent();
    }

    formatPrice(num) {
        let p = (num/100).toFixed(2).split(".");
        return p[0].split("").reverse().reduce(function(acc, num, i, orig) {
            return num + (num != "-" && i && !(i % 3) ? "." : "") + acc;
        }, "") + "," + p[1];
    }

    removeFromCartItemsWithZeroQty(){
        this.cart_items.forEach((cart_item, index)=>{
            if(cart_item.qty==0){
                this.cart_items.splice(index, 1);
                this.setStorageContent();
            }
        });
    }

    updateCartWithDataFromBackend(id, msg, solution, className){
        let trs=document.getElementsByClassName('cart_item');
        //loop through every row in cart and show error messages and change values of price and/or qty available
        for(let i=0; i<trs.length; i++){
            let tr_id=trs[i].getAttribute('data-id');
            if(tr_id == id){
                let tag_to_change=trs[i].getElementsByClassName(className)[0]; //input (for qty) or h5 (for price)
                //for cart and checkout page
                tag_to_change.style.color="red";
                //for cart and checkout page
                if(tag_to_change.classList.contains('price')){
                    tag_to_change.textContent=this.formatPrice(solution);
                }
                //for cart page only
                if(tag_to_change.classList.contains('quantity')){
                    tag_to_change.value=solution;
                }
                //for checkout page only
                if(tag_to_change.classList.contains('checkout_quantity')){
                    tag_to_change.textContent=solution;
                }
                let error_tag=trs[i].getElementsByClassName('cart_error')[0];
                error_tag.classList.remove('d-none');
                error_tag.textContent=msg;
            }
        }

    }
}


class AddToCartFromCategoryPage extends BaseCart{
    constructor(){
        super();
        this.giveListeners();
    }
    giveListeners(){
        let add_to_carts=document.getElementsByClassName('add_to_cart');
        for(let i=0; i<add_to_carts.length; i++){
            add_to_carts[i].addEventListener('click', (e)=>{
                this.collectData(e.target.closest('ul'));
                this.showCartQuantityInNav();
            })
        }
    }
}

class AddToCartFromShowProductPage extends BaseCart{
    constructor(){
        super();
        this.qty_error=document.getElementById('qty_error');

        this.qty=document.getElementById('qty');
        this.max_qty=document.getElementById('add_to_cart').getAttribute('data-stock');
        this.giveListeners();

    }
    giveListeners(){
       let btn_minus=document.getElementById('btn_minus');
       let btn_plus=document.getElementById('btn_plus');
       let add_to_cart=document.getElementById('add_to_cart');
       btn_minus.addEventListener('click', (e)=>{
           this.hideQtyError();
           if(this.qty.value>1){
               this.qty.value = parseInt(this.qty.value)-1;
           }
       });

       btn_plus.addEventListener('click', (e)=>{
           this.hideQtyError();
           if(this.qty.value<this.max_qty){
               this.qty.value = parseInt(this.qty.value)+1;
           }else{
               this.showQtyError();
           }
        });

        add_to_cart.addEventListener('click', (e)=>{
            this.collectData(e.target, this.qty.value);
            this.showCartQuantityInNav();
        });

    }

    hideQtyError(){
       this.qty_error.classList.add('d-none');
    }
    showQtyError(){
        this.qty_error.classList.remove('d-none');
    }
}

class Cart extends BaseCart{
    constructor(){
        super();
        this.route='/check-cart-items-and-coupon';
        this.renderPage();
        this.giveListeners();

    }


    renderPage(){
        let page=document.querySelector('title').textContent;
        if(page.split(' ').pop().toLowerCase()==="cart"){

            if(this.cart_items.length) {
//                console.log(this.cart_items)
                this.calculateTotalsAndCartQty();
                this.showCartContent();
                this.showCartTotals();
            }
        }

    }

    showCartContent(){
        this.getStorageContent();
        //since we have items, we show them and hide "no items in cart" message
        document.getElementById('no_items').classList.add('d-none');
        document.getElementsByClassName('table')[0].classList.remove('d-none');

        let cart_items_table = document.getElementById('cart_items');
        let rows = this.cart_items.map((item) => {
            return `
                <tr class="cart_item" data-id="${item.id}">
                    <td>
                        <button class="btn btn-outline-danger remove">X</button>
                    </td>
                    <td>
                        <div class="media ">
                            <div class="d-flex d-phone-none">
                                <img width="80px" src="/${item.image}" alt="product_image">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="media ">
                            <div class="media-body">
                            <p class="text-danger cart_error d-none"></p>
                                <a href="/show-product/${item.slug}">${item.name}</a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <h5 class="price">${this.formatPrice(item.selling_price)}</h5>
                    </td>
                    <td class="qty_col">
                        <p class="qty_error text-danger d-none">You can't order more quantities</p>
                        <div class="d-flex align-items-center  md-column ">
                            <button class="btn-outline-blue mr-1 btn_minus" type="button" ><i class="fas fa-minus"></i></button>
                            <input disabled type="number" name="qty" value="${item.qty}" class="quantity qty mr-1" min="1" max="">
                            <button class="btn-outline-blue mr-3 btn_plus" type="button"><i class="fas fa-plus"></i></button>
                        </div>
                    </td>
                    <td>
                        <h5 class="single_total">${this.formatPrice(item.subtotal)}</h5>
                    </td>
                </tr>
            `;
        });
        cart_items_table.innerHTML = rows.join('');
    }

    showCartTotals(){
        document.getElementById('subtotal').textContent=this.formatPrice(this.subtotal);
        document.getElementById('subtotal_with_coupon').textContent=this.formatPrice(this.subtotal_with_coupon);
        document.getElementById('shipping_fee').textContent=this.formatPrice(this.shipping_fee);
        document.getElementById('total').textContent=this.formatPrice(this.total);

        if(this.coupon_is_applied){
            let coupon_tags=document.getElementsByClassName('have_coupon');
            let coupon_toggle=document.getElementById('coupon_toggle');
            document.getElementById('coupon_input').value=this.coupon.code;
            if(coupon_toggle.classList.contains('coupons_hidden') ){
                coupon_toggle.classList.remove('coupons_hidden');
                coupon_toggle.textContent="I don't want to use Coupon"
                for(let i=0; i<coupon_tags.length; i++){
                    coupon_tags[i].classList.remove('d-none');
                }
            }
        }
    }

    giveListeners(){
        let pluses=document.getElementsByClassName('btn_plus');
        let minuses=document.getElementsByClassName('btn_minus');
        let removes=document.getElementsByClassName('remove');
        let coupon_toggle=document.getElementById('coupon_toggle');
        let apply_coupon=document.getElementById('apply_coupon');
        let go_to_checkout=document.getElementById('go_to_checkout');

        if(go_to_checkout){
            go_to_checkout.addEventListener('click', ()=>{
                this.checkCartItemsAndCoupon();
            });
        }

        if(apply_coupon){
            apply_coupon.addEventListener('click', ()=>{
                this.applyCoupon();
            });
        }

        if(coupon_toggle){
            coupon_toggle.addEventListener('click', (e)=>{
                this.toggleAddCoupon(coupon_toggle);
            });
        }

        if(pluses && minuses && removes){

            for(let i=0; i<pluses.length; i++){
                pluses[i].addEventListener('click', (e)=>{
                    this.increaseQty(e);
                })
            }

            for(let i=0; i<minuses.length; i++){
                minuses[i].addEventListener('click', (e)=>{
                    this.decreaseQty(e);
                })
            }

            for(let i=0; i<removes.length; i++){
                removes[i].addEventListener('click', (e)=>{
                    this.removeFromCartHtml(e);
                })
            }
        }
    }

    removeFromCartHtml(e){
        let tr=e.target.closest('tr');
        this.showModalMessage('Item removed from the cart', 'bg-success');
        tr.classList.add('bg-danger');
        setTimeout(()=>{
            tr.remove();
        },800);

        let id=tr.getAttribute('data-id');
        this.removeItemFromCartState(id);
        this.setStorageContent();
        this.showCartQuantityInNav();

        if(this.cart_qty){
            this.showCartTotals();
        }else{
            document.getElementById('no_items').classList.remove('d-none');
            document.getElementsByClassName('table')[0].classList.add('d-none');
        }
    }



    changeTotalPerItem(tr, qty, price){
        let total_placeholder=tr.getElementsByClassName('single_total')[0];
        //console.log(total_placeholder, price, qty)
        total_placeholder.textContent=this.formatPrice(parseInt(price)*parseInt(qty));
    }

    removeItemFromCartState(id){
        this.cart_items.forEach((cart_item, index)=>{
            if(parseInt(id)===parseInt(cart_item.id)){
                this.cart_items.splice(index, 1);
                this.calculateTotalsAndCartQty();
            }
        });
    }


    decreaseQty(e){
        let tr=e.target.closest('tr');
        let input=tr.getElementsByTagName('input')[0];
        let id=tr.getAttribute('data-id');

        if(input.value>0){
            let new_qty=parseInt(input.value)-1;
            input.value = new_qty;
            this.cart_items.forEach((cart_item)=>{
                if(parseInt(id)===parseInt(cart_item.id)){
                    cart_item.qty=new_qty;
                    cart_item.subtotal=parseInt(new_qty) * parseInt(cart_item.selling_price);
                    this.changeTotalPerItem(tr, new_qty, cart_item.selling_price);
                    this.calculateTotalsAndCartQty();
                    this.setStorageContent();
                    this.showCartTotals();
                    this.showCartQuantityInNav();
                }
            });
        }
    }

    increaseQty(e){
        let tr=e.target.closest('tr');
        let input=tr.getElementsByTagName('input')[0];
        let id=tr.getAttribute('data-id');
        this.cart_items.forEach((cart_item)=>{
            if(id==cart_item.id){
                let max_qty=cart_item.stock;
                if(input.value<max_qty){
                    let new_qty=parseInt(input.value)+1;
                    input.value = new_qty;
                    cart_item.qty=new_qty;
                    cart_item.subtotal=new_qty * parseInt(cart_item.selling_price);
                    this.changeTotalPerItem(tr, new_qty, cart_item.selling_price);
                    this.calculateTotalsAndCartQty();
                    this.setStorageContent();
                    this.showCartTotals();
                    this.showCartQuantityInNav();

                }else{
                    //show for 2 sconds that user can't order more quantity
                    let td=e.target.closest('td');
                    let msg=td.getElementsByClassName('qty_error')[0];
                    let input=td.getElementsByTagName('input')[0];
                    msg.classList.remove('d-none');
                    input.classList.remove('quantity');
                    input.classList.add('quantity_error');
                    setTimeout(function(){
                        msg.classList.add('d-none');
                        input.classList.add('quantity');
                        input.classList.remove('quantity_error');
                    }, 2000);
                }

            }
        });

    }


    toggleAddCoupon(coupon_toggle){
        let coupon_tags=document.getElementsByClassName('have_coupon');
        if(coupon_toggle.classList.contains('coupons_hidden') ){
            coupon_toggle.classList.remove('coupons_hidden');
            coupon_toggle.textContent="Remove Coupon"
            for(let i=0; i<coupon_tags.length; i++){
                coupon_tags[i].classList.remove('d-none');
            }
        }else{
            coupon_toggle.classList.add('coupons_hidden');
            coupon_toggle.textContent="Do you have a Coupon?"
            for(let i=0; i<coupon_tags.length; i++){
                coupon_tags[i].classList.add('d-none');
            }
            this.coupon_is_applied=false;
            this.showModalMessage('Coupon removed successfully!', 'bg-warning')
            this.setStorageContent();
        }
    }

    applyCoupon(){
        let coupon_value=document.getElementById('coupon_input').value;
        if(coupon_value.trim()){
            //check if coupon exists and is valid. also, retrieve value
            axios.get('/check-coupon/'+coupon_value).then((data)=>{
                //console.log(data.data)
                if(data.data.hasOwnProperty('error')){
                    this.showModalMessage(data.data.error, 'bg-danger');
                    this.coupon_is_applied=false;
                    this.coupon=null;
                    this.calculateTotalsAndCartQty();
                    this.setStorageContent();
                    this.showCartTotals();
                }else if(data.data.hasOwnProperty('success')){
                    this.showModalMessage('Coupon is applied successfully!', 'bg-success');
                    this.coupon=data.data.success;
                    this.coupon_is_applied=true;
                    this.calculateTotalsAndCartQty();
                    this.setStorageContent();
                    this.showCartTotals();
                    this.showCartQuantityInNav();
                }
            });

        }
    }

    //sends items from local storage to backend for check
    checkCartItemsAndCoupon(){
        this.getStorageContent();
        this.removeFromCartItemsWithZeroQty();
        if(this.cart_qty ===0){
            this.showModalMessage('There are no items in your cart. Please, add some items.', 'bg-warning')
            return;
        }

        let formData=new FormData();

        this.coupon_is_applied ?? formData.append('coupon',JSON.stringify(this.coupon));
        formData.append('items',JSON.stringify(this.cart_items));
        formData.append('_token',document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        axios.post(this.route, formData).then((data)=>{
            //console.log(data.data.products_in_cart)
            console.table(data.data)
            //we have some errors...
            if(data.data.hasOwnProperty('errors')){
                this.showModalMessage('There are some errors. Please, check carefully!', 'bg-danger');
                this.giveListeners();
               //this.solveErrorsInCart(data);
                if(data.data.hasOwnProperty('products_in_cart')){
                    console.log(data.data.products_in_cart)
                    this.cart_items=data.data.products_in_cart;
                    this.calculateTotalsAndCartQty();
                    this.setStorageContent();
                    this.showCartContent();
                    this.showCartTotals();
                    this.showCartQuantityInNav();
                }
                if(data.data.errors.hasOwnProperty('items')){
                    let resp_object=data.data.errors.items;
                    let ids=Object.keys(resp_object);
                    for(let i=0; i<ids.length; i++){
                        let inner_keys=Object.keys(resp_object[ids[i]]);
                        inner_keys.forEach((inner_key)=>{
                            if(inner_key=='qty' || inner_key=='price'){
                                let msg=resp_object[ids[i]][inner_key]['msg'];
                                let solution=resp_object[ids[i]][inner_key]['solution'];
                                this.updateCartWithDataFromBackend(ids[i], msg, solution, inner_key);
                            }else{
                                console.log('key unknown');
                            }
                        });
                    }
                }

                if(data.data.errors.hasOwnProperty('coupon')){
                    this.showModalMessage(data.data.errors.coupon, 'bg-danger');
                    this.coupon=null;
                    this.coupon_is_applied=false;
                    this.subtotal_with_coupon=0;

                    this.calculateTotalsAndCartQty();
                    this.setStorageContent();
                    this.showCartTotals();
                }

            }//end if data.data.hasOwnProperty('errors')

            if(data.data.hasOwnProperty('location')){
                window.location=data.data.location
            }
        });
    }


    updateCartWithDataFromBackend(id, msg, solution, className){
        let trs=document.getElementsByClassName('cart_item');
        //loop through every row in cart and show error messages and change values of price and/or qty available
        for(let i=0; i<trs.length; i++){
            let tr_id=trs[i].getAttribute('data-id');
            if(tr_id == id){
                let tag_to_change=trs[i].getElementsByClassName(className)[0]; //input (for qty) or h5 (for price)
                tag_to_change.style.color="red";
                if(tag_to_change.classList.contains('price')){
                    tag_to_change.textContent=this.formatPrice(solution);
                }
                if(tag_to_change.classList.contains('quantity')){
                    tag_to_change.value=solution;
                }

                let error_tag=trs[i].getElementsByClassName('cart_error')[0];
                error_tag.classList.remove('d-none');
                error_tag.textContent +=msg;
            }
        }

    }

}

class Checkout extends BaseCart{
    constructor() {
        super();
        this.route='/create-order';
        //this.checkCartItemsAndCoupon();
        this.renderListOfProductsWithTotals();
        //console.log(this)
        this.form;
        this.addListeners();


    }

    showErrorModalMessageIfSessionError(){
        let error_div=document.getElementById('backend_errors');

        if(error_div){
            this.showModalMessage('There are some errors. Please, check carefully!', 'bg-danger', 5000);
        }
    }

    renderListOfProductsWithTotals() {
        let html_placeholder=document.getElementById('checkout_list');
        html_placeholder.innerHTML="";
        this.removeFromCartItemsWithZeroQty();
        let rows=this.cart_items.map((item)=>{
            return `
                        <li class="error_placeholder text-danger d-none" data-id="${item.id}"></li>
                        <li class="cart_item" >
                        <a href="/show-product/${item.slug}">${item.name}
                            <span class="middle price ">${this.formatPrice(item.selling_price)}</span>
                            <span class="middle qty checkout_qty">x ${item.qty}</span>
                            <span class="price last">${this.formatPrice(item.subtotal)}</span>
                        </a>
                    </li>`;
        });
         html_placeholder.innerHTML +=rows.join(' ');

        document.getElementById('checkout_subtotal').textContent=this.formatPrice(this.subtotal);
        if(this.coupon_is_applied) {
            console.log(this.coupon_is_applied, this.coupon)
            document.getElementById('checkout_subtotal_with_coupon').textContent = this.formatPrice(this.subtotal_with_coupon);
            document.getElementById('coupon_placeholder').classList.remove('d-none')
        }else{
            document.getElementById('checkout_subtotal_with_coupon').textContent = this.formatPrice(0);
            document.getElementById('coupon_placeholder').classList.add('d-none')
        }
        document.getElementById('checkout_shipping_fee').textContent=this.formatPrice(this.shipping_fee);
        document.getElementById('checkout_total').textContent=this.formatPrice(this.total);

    }

    updateCheckoutWithDataFromBackend(id, msg, solution, className){
    console.log(id, msg, solution, className)//1, There are only 14 pc(s) left on the stock for this item., 14, ['qty']
    let hidden_lis=document.getElementsByClassName('error_placeholder');
    for(let i=0; i<hidden_lis.length; i++){
        if(id==hidden_lis[i].getAttribute('data-id')){
            if(className=='price') {
                let price_placeholder = hidden_lis[i].nextElementSibling.getElementsByClassName('price')[0];
                //price_placeholder.classList.remove();
                price_placeholder.classList.add('text-danger');
            }
            if(className=='qty'){
                let qty_placeholder=hidden_lis[i].nextElementSibling.getElementsByClassName('qty')[0];
                //price_placeholder.classList.remove();
                qty_placeholder.classList.add('text-danger');
            }

            hidden_lis[i].textContent += msg;
            hidden_lis[i].classList.remove('d-none');
        }
    }

    }
    togglePaymentRadioButtons(){
        let radios=document.querySelectorAll('.selector');
        radios.forEach((radio)=>{
            radio.addEventListener('change', (e)=>{
                this.togglePaymentOptions(e);
            });
        });
    }


    togglePaymentOptions(e){
        let divs=document.querySelectorAll('.payment_section');
        divs.forEach((div)=>{
            div.classList.add('d-none');
        });
        let sibling=e.target.parentElement.lastElementChild;
        sibling.classList.remove('d-none');

    }

    createAdditionalFieldInForm(name, value){
        let input=document.createElement('input');
        input.setAttribute('name', name);
        input.setAttribute('value', value);
        this.form.appendChild(input);
    }



    addListeners(){
        this.togglePaymentRadioButtons();

        let cod_btn=document.getElementById('cod_button');
        let card_btn=document.getElementById('card_button');

        cod_btn.addEventListener('click', (e)=>{
            e.preventDefault();
            this.tryToOrder(e, 'cod');
        });

        card_btn.addEventListener('click', (e)=>{
            e.preventDefault();
            this.tryToOrder(e, 'card');
        });
    }

    tryToOrder(e, payment_type){
        let modal_msg="";
        if(payment_type==="cod"){
            modal_msg='Are you sure that you want to order these products and pay with CASH ON DELIVERY? Click "Confirm" to finish your order.';
        } else if(payment_type==="card"){
            modal_msg='Are you sure that you want to order these products and pay with CREDIT CARD? Click "Confirm" to finish your order.';
        }
        document.getElementById('confirmation_modal_body').textContent=modal_msg;

        document.getElementById('confirm_modal_button').addEventListener('click', (e)=>{
            e.preventDefault();
            e.stopImmediatePropagation();
            //this.form=document.getElementById('checkout_form');
            //collect data from form and put them in formData
            let formData=new FormData();
            let names=['confirm_terms', 'name', 'contact_person','email', 'address', 'city', 'zip', 'phone1', 'phone2','comment'];
            names.forEach( (name)=>{
                formData.append(name, document.querySelector("[name="+name+"]").value);
            });
            if(payment_type==="card"){
                let card_names=['card_number', 'expiry_month', 'expiry_year', 'cvc'];
                card_names.forEach( (name)=>{
                    formData.append(name, document.querySelector("[name="+name+"]").value);
                });
            }

            formData.append('items', JSON.stringify(this.cart_items));
            formData.append('payment_type', payment_type);
            $('#confirmation_modal').modal('hide')
            if(this.coupon_is_applied){
                formData.append('coupon', JSON.stringify(this.coupon));
            }
            axios.post(this.route, formData).then((data)=>{
                if(data.data.hasOwnProperty('errors')){
                    this.showModalMessage('There are some errors. Please, check carefully!', 'bg-danger', 6000);

                    if(data.data.hasOwnProperty('products_in_cart')){
                        this.cart_items=data.data.products_in_cart;
                        this.calculateTotalsAndCartQty();
                        this.setStorageContent();
                        this.renderListOfProductsWithTotals();
                        this.showCartQuantityInNav();
                    }
                    if(data.data.hasOwnProperty('items')){
                        let resp_object=data.data.items;
                        let ids=Object.keys(resp_object);
                        for(let i=0; i<ids.length; i++){
                            let inner_keys=Object.keys(resp_object[ids[i]]);
                            inner_keys.forEach((inner_key)=>{
                                if(inner_key==='qty' || inner_key==='price'){
                                    let msg=resp_object[ids[i]][inner_key]['msg'];
                                    let solution=resp_object[ids[i]][inner_key]['solution'];
                                    this.updateCheckoutWithDataFromBackend(ids[i], msg, solution, inner_key);
                                }else{
                                    console.log('key unknown');
                                }
                            });
                        }
                    }

                    if(data.data.hasOwnProperty('coupon')){
                        this.showModalMessage(data.data.coupon, 'bg-danger');
                        this.coupon=null;
                        this.coupon_is_applied=false;
                        this.subtotal_with_coupon=0;
                        document.getElementById('coupon_placeholder').classList.add('d-none');
                        this.calculateTotalsAndCartQty();
                        this.setStorageContent();
                        this.renderListOfProductsWithTotals();
                        this.showCartQuantityInNav();
                    }
                    if(data.data.hasOwnProperty('validation')){
                        let resp_object=data.data.validation;
                        for(let input_name in resp_object){
                            let errors_arr=resp_object[input_name]
                            errors_arr.forEach((error_msg)=>{
                                this.showErrorMessageBellowInput(input_name, error_msg);
                            });
                        }
                    }
                    if(data.data.hasOwnProperty('card_number')){
                        this.showModalMessage('Please, check all the fields regarding your credit card information.', 'bg-danger', 5000);
                        this.showErrorMessageBellowInput('card_number', data.data.card_number)
                    }
                    if(data.data.hasOwnProperty('expiry_year')){
                        this.showModalMessage('Please, check all the fields regarding your credit card information.', 'bg-danger', 5000);
                        this.showErrorMessageBellowInput('expiry_year', data.data.expiry_year)
                    }
                    if(data.data.hasOwnProperty('expiry_month')){
                        this.showModalMessage('Please, check all the fields regarding your credit card information.', 'bg-danger', 5000);
                        this.showErrorMessageBellowInput('expiry_month', data.data.expiry_month)
                    }
                    if(data.data.hasOwnProperty('cvc')){
                        this.showModalMessage('Please, check all the fields regarding your credit card information.', 'bg-danger', 5000);
                        this.showErrorMessageBellowInput('cvc', data.data.cvc)
                    }
                    if(data.data.hasOwnProperty('other_error')){
                        this.showModalMessage('Some error occurred. Please, wait for few moments and also, please, check all the fields regarding your credit card information.', 'bg-danger', 11000);
                        this.showErrorMessageBellowInput('card_number', '');
                        this.showErrorMessageBellowInput('expiry_year', '');
                        this.showErrorMessageBellowInput('expiry_month', '');
                        this.showErrorMessageBellowInput('cvc', '');

                    }

                }//end if data.data.hasOwnProperty('errors')
                if(data.data.hasOwnProperty('location')){
                    window.location=data.data.location;
                }
            });

        });

    }

    //error msg in red color bellow input and red border around input
    showErrorMessageBellowInput(input_name, error_msg){
        //console.log(input_name, error_msg)
        let input_field=document.querySelector('input[name="'+input_name+'"]');
        input_field.classList.add('custom-is-invalid');
        let error_div=input_field.parentElement.getElementsByClassName('fc_error')[0];
        error_div.innerHTML=error_msg+"<br>";
        input_field.addEventListener('change', (e)=>{
            input_field.classList.remove('custom-is-invalid');
            error_div.innerHTML="";
        });
    }




}

class ThankYou extends BaseCart{
    constructor(props) {
        super(props);
        this.clearStorage();
        this.initiateBaseCartProps();
        this.showCartQuantityInNav();
    }

}

