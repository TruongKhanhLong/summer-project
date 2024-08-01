<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\OrderStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->String("order_id");
            $table->String("booking_number");
            $table->String("customer_name");
            $table->String("transport_type");
            $table->String("order_type");
            $table->String("services");
            $table->integer("amount");
            $table->integer("number_of_tons");
            $table->integer("number_of_m3");
            $table->String("receive_order_address");
            $table->String("delivery_address");
            $table->String("pakage_group");
            $table->String("pakage_type");
            $table->timestamp("cut_off_time");
            $table->String("order_status")->default(OrderStatus::NEW_ORDER);
            $table->timestamps("order_date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
