<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends CheckoutController
{
    //

    public function createOrder(Request $request)
    {
        return parent::createOrder($request); // TODO: Change the autogenerated stub

        $this->populateClassProps($request);
        //da li req ima kupon. ako ima, this. coupon je req kupon
        //this user items je req items.
        // izdvaja ids proizvoda

        $this->checkItems();
        //uzima sve proizvode iz db na osnovu id
        //u njoj su
            $this->removeProductsThatDontExist($products_from_DB);
            //ova metoda popunjava this user items with updated values ALI SAMO AKO NE POSTOJI ID

            $this->checkDifferenceBetweenCartAndDB($products_from_DB);
            //da li su stock, i cene različite
            //ako jesu POPUNJAVA THIS ITEM ERRORS
            //ako jesu, MENJA VREDNOSTI this user items with updated values KAO DA JE KORISNIK PROMENIO
            //količina na stanju se smanjila
                $this->createErrorMsg($product->id, 'qty',"There are only $product->stock left on the stock for this item.", $product->stock);
                $this->changeValuesInCartItems($product->id, 'stock', $product->stock);
                $this->changeValuesInCartItems($product->id, 'qty', $product->stock);
                $correct_qty=$product->stock;
            //neka od cena se promenila regular ili action
            //apdejtujemo  this user items with updated values. takodje i subtotale za svaki artikal


        $this->checkCoupon();
//ako nema grešaka, započni transakcije. a ko popunjava greške?
        //to radi prot fun return resposne to front end
        if(!$this->request_errors){
            DB::beginTransaction();

        }

    }


}