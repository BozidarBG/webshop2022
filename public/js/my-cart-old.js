//pre nego što sam video da ne može tako i da mora
//promenta stejta, računanje svega, prikaz svega, ubacivanje u local storage
class LocalStorage{
    constructor() {
        this.storage="aroma_cart";
        this.cart_items=[];
        this.cart_qty=0;
        this.subtotal=0;
        this.subtotal_with_coupon=0;
        this.total=0;
        this.shipping_fee=0;
        this.coupon={};
        this.coupon_is_applied=false;
        this.getStorageContent();
        this.showCartQuantityInNav();
    }

    showCartQuantityInNav(){
        this.getStorageContent();
        let items=0;
        //console.log(this.cart_items)
        if(this.cart_items.length){
            //console.log(this.cart_items)
            this.cart_items.forEach((item)=>{
                items +=item.qty;
            });
        }


        this.cart_qty=items;
        document.getElementsByClassName('nav-shop__custom-circle')[0].textContent=items;
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
        //console.log(this)
        if(content){
            this.cart_items=content.cart_items;
            this.coupon=content.coupon;
            this.coupon_is_applied=content.coupon_is_applied;
        }

    }

    setStorageContent(){
        let content={};
        content.coupon=this.coupon;
        content.coupon_is_applied=this.coupon_is_applied;
        content.cart_items=this.cart_items;

        console.log(content)
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
            this.setStorageContent();
            this.showModalMessage('Item added to the cart', 'bg-success');

        }

    }

}

class showCartQuantity extends LocalStorage{
    constructor() {
        super();
        this.showCartQuantityInNav();
    }
    showCartQuantityInNav(){
        this.getStorageContent();
        let items=0;
        this.cart_items.forEach((item)=>{
            items +=item.qty;
        });

        document.getElementsByClassName('nav-shop__custom-circle')[0].textContent=items;
    }
}

class AddToCartFromCategoryPage extends LocalStorage{
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

class AddToCartFromShowProductPage extends LocalStorage{
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

class Cart extends LocalStorage{
    constructor(){
        super();

            this.showCartContent();
            this.giveListeners();

    }


    showCartContent(){
        let page=document.querySelector('title').textContent;
        if(page.split(' ').pop()=="cart"){
            this.getStorageContent();
            //if we have items, we show them and hide "no items in cart" message
            if(this.cart_items.length) {
                document.getElementById('no_items').classList.add('d-none');
                document.getElementsByClassName('table')[0].classList.remove('d-none');

                let cart_items_table = document.getElementById('cart_items');
//            console.log(this.cart_items);
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
                            <input disabled type="number" name="qty" value="${item.qty}" class="quantity mr-1" min="1" max="">
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
                this.calculateAndShowCartTotals();
            }
        }


    }

    giveListeners(){
        //cart page
        let table=document.getElementById('cart_items');
        let pluses;
        let minuses;
        let removes;
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
                //console.log(coupon_toggle)
            });
        }

        if(table){
            pluses=table.getElementsByClassName('btn_plus');
            minuses=table.getElementsByClassName('btn_minus');
            removes=table.getElementsByClassName('remove');

            if(pluses){
                for(let i=0; i<pluses.length; i++){
                    pluses[i].addEventListener('click', (e)=>{
                        this.increaseQty(e);
                    })
                }
            }
            if(minuses){
                for(let i=0; i<minuses.length; i++){
                    minuses[i].addEventListener('click', (e)=>{
                        this.decreaseQty(e);
                    })
                }
            }
            if(removes){
                for(let i=0; i<removes.length; i++){
                    removes[i].addEventListener('click', (e)=>{
                        this.removeFromCart(e);
                    })
                }
            }
        }


    }

    removeFromCart(e){
        let tr=e.target.closest('tr');
        let id=tr.getAttribute('data-id');
        this.cart_items.forEach((cart_item, index)=>{
            if(id==cart_item.id){
                this.cart_items.splice(index, 1);
                this.setStorageContent();
                this.calculateAndShowCartTotals();
                this.showCartQuantityInNav();
                this.showModalMessage('Item removed from the cart', 'bg-success');
                tr.classList.add('bg-danger');
                setTimeout(()=>{
                    tr.remove();
                },800);
            }
        });
    }

    changeTotalPerItem(tr, qty, price){
        let total_placeholder=tr.getElementsByClassName('single_total')[0];
        //console.log(total_placeholder, price, qty)
        total_placeholder.textContent=this.formatPrice(parseInt(price)*parseInt(qty));
    }

    calculateAndShowCartTotals(){
        let subtotal=0;
        let cart_qty=0;
        this.cart_items.forEach((item)=>{
            subtotal +=item.subtotal;
            cart_qty +=item.qty;
        });
        this.subtotal=subtotal;
        this.cart_qty=cart_qty;
        //console.log(this.coupon)
        //console.log(this.subtotal)
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

        if(this.cart_qty){
            if(this.subtotal >=500000){
                this.shipping_fee=0;
            }else{
                this.shipping_fee=100000;
            }
        }else{
            this.shipping_fee=0;
        }

        this.total=this.subtotal_with_coupon>0 ? this.shipping_fee+this.subtotal_with_coupon : this.shipping_fee+this.subtotal;

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
        console.log(this)
    }

    formatPrice(num) {
        let p = (num/100).toFixed(2).split(".");
        return p[0].split("").reverse().reduce(function(acc, num, i, orig) {
            return num + (num != "-" && i && !(i % 3) ? "." : "") + acc;
        }, "") + "," + p[1];
    }

    decreaseQty(e){
        let tr=e.target.closest('tr');
        let input=tr.getElementsByTagName('input')[0];
        let id=tr.getAttribute('data-id');

        if(input.value>0){
            let new_qty=parseInt(input.value)-1;
            input.value = new_qty;
            this.cart_items.forEach((cart_item)=>{
                if(id==cart_item.id){
                    cart_item.qty=new_qty;
                    cart_item.subtotal=parseInt(new_qty) * parseInt(cart_item.selling_price);
                    this.changeTotalPerItem(tr, new_qty, cart_item.selling_price);
                    this.setStorageContent();
                    this.calculateAndShowCartTotals();
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
                    this.setStorageContent();
                    this.calculateAndShowCartTotals();
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
            coupon_toggle.textContent="I don't want to use Coupon"
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
                }else if(data.data.hasOwnProperty('success')){
                    this.coupon=data.data.success;
                    this.coupon_is_applied=true;
                    this.setStorageContent();
                    this.calculateAndShowCartTotals();
                    //console.log(coupon.type)
                }
            });

        }
    }

    removeFromCartItemsWithZeroQty(){
        this.cart_items.forEach((cart_item, index)=>{
            if(cart_item.qty==0){
                this.cart_items.splice(index, 1);
                this.setStorageContent();
            }
        });
    }


    //sends items from local storage to backend for check
    checkCartItemsAndCoupon(){
        this.getStorageContent();
        this.removeFromCartItemsWithZeroQty();
        let formData=new FormData();
        //console.log(this.coupon, this.coupon_is_applied, this.cart_items)
        this.coupon_is_applied ? formData.append('coupon',JSON.stringify(this.coupon)) : formData.append('coupon', null);
        formData.append('items',JSON.stringify(this.cart_items));
        formData.append('_token',document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        axios.post('/check-cart-items', formData).then((data)=>{
            console.log(data.data.products_in_cart)
            console.log(this.cart_items)
            if(data.data.hasOwnProperty('errors')){
                console.log(data.data.errors)
                if(data.data.errors.hasOwnProperty('items')){
                    let resp_object=data.data.errors.items;
                    let ids=Object.keys(resp_object);
                    //console.log(ids)//[338, 377]
                    //console.log(id)//338 ok
                    //console.log(resp_object[id]);//{"qty": {"msg": "There are only 2 left on the stock for item Praesentium unde magnam repellendus.", "solution": 2}
                    //console.log(Object.keys(resp_object[id])[0])//qty ok
                    for(let i=0; i<ids.length; i++){
                        let inner_key=Object.keys(resp_object[ids[i]]);
                        //console.log(inner_key)//qty ok
                        if(inner_key=="qty"){
                            //console.log(Object.keys(resp_object[id])[0])//reč qty
                            //console.log(resp_object[id][inner_key])//{msg: 'There are only 2 left on the stock for item Praesentium unde magnam repellendus.', solution: 2}
                            //console.log(resp_object[id][inner_key]['msg'], resp_object[id][inner_key]['solution'])
                            let msg=resp_object[ids[i]][inner_key]['msg'];
                            let solution=resp_object[ids[i]][inner_key]['solution'];
                            //console.log(msg, solution, ids[i])
                            this.updateCartWithDataFromBackend(ids[i], msg, solution, 'quantity');

                        }
                        if(inner_key=='price'){
                            let msg=resp_object[ids[i]][inner_key]['msg'];
                            let solution=resp_object[ids[i]][inner_key]['solution'];
                            //console.log(msg, solution, ids[i])
                            this.updateCartWithDataFromBackend(ids[i], msg, solution, 'price');
                        }
                    }


                }

                if(data.data.errors.hasOwnProperty('coupon')){
                    console.log(data.data.errors.coupon)
                    this.showModalMessage(data.data.errors.coupon, 'bg-danger');
                    this.coupon=null;
                    this.coupon_is_applied=false;
                }
            }
            if(data.data.hasOwnProperty('products_in_cart')){
                this.cart_items=data.data.products_in_cart;
                this.setStorageContent();
                this.calculateAndShowCartTotals();
                this.showCartQuantityInNav();

            }
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
                tag_to_change.tagName=="INPUT" ? tag_to_change.value=solution : tag_to_change.textContent=this.formatPrice(solution);
                let error_tag=trs[i].getElementsByClassName('cart_error')[0];
                error_tag.classList.remove('d-none');
                error_tag.textContent=msg;


            }
        }

    }

}

class Checkout extends Cart{
    constructor() {
        super();
        this.showTotals();
        console.log(this)

    }

    showTotals(){
        window.onload=()=>{
            console.log(this)
            document.getElementById('checkout_subtotal').textContent=this.formatPrice(this.subtotal);
            document.getElementById('checkout_shipping_fee').textContent=this.formatPrice(this.shipping_fee);
            document.getElementById('checkout_total').textContent=this.formatPrice(this.total);
        }

    }

    calculate(){
        //totals per item (qty * selling_price)
        this.cart_items.forEach((item)=>{
            this.subtotal +=item.subtotal;
            this.cart_qty +=item.qty;
        });
        //coupon?
        if(this.coupon_is_applied){

        }
        //shipping fee

        //total with coupon and shipping fee

    }

}




