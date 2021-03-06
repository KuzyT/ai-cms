<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMangaTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('category', 40)->unique();
			$table->text('description')->nullable();
			$table->string('cover',255)->nullable();
			$table->timestamps();
		});

		Schema::create('mangas', function(Blueprint $table){
			$table->bigIncrements('id');
			$table->bigInteger('user_id')->unsigned()->nullable();
			$table->string('title', 200);
			$table->string('cover', 255);
			$table->integer('views')->unsigned()->default(0);
			$table->text('meta')->nullable();
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('CASCADE');
		});

		Schema::create('category_manga', function (Blueprint $table) {
			$table->bigInteger('category_id')->unsigned();
			$table->bigInteger('manga_id')->unsigned();

			$table->foreign('category_id')->references('id')->on('categories')->onDelete('CASCADE')->onUpdate('CASCADE');
			$table->foreign('manga_id')->references('id')->on('mangas')->onDelete('CASCADE')->onUpdate('CASCADE');
		});

		Schema::create('ratings', function (Blueprint $table){
			$table->bigIncrements('id');
			$table->bigInteger('manga_id')->unsigned();
			$table->bigInteger('user_id')->unsigned();
			$table->tinyInteger('rating')->unsigned();
			$table->timestamps();

			$table->foreign('manga_id')->references('id')->on('mangas')->onDelete('CASCADE')->onUpdate('CASCADE');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
		});

		Schema::create('comments', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('user_id')->unsigned();

			$table->text('comment');
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
		});

		Schema::create('commentable', function (Blueprint $table) {
			$table->bigInteger('comment_id');
			$table->bigInteger('commentable_id')->unsigned();
			$table->string('commentable_type');
		});

		Schema::create('favorites', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('manga_id')->unsigned();
			$table->bigInteger('user_id')->unsigned();
			$table->timestamps();

			$table->foreign('manga_id')->references('id')->on('mangas')->onDelete('CASCADE')->onUpdate('CASCADE');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('favorites', function (Blueprint $table) {
			$table->dropForeign('favorites_manga_id_foreign');
			$table->dropForeign('favorites_user_id_foreign');
		});

		Schema::table('comments', function (Blueprint $table) {
			$table->dropForeign('comments_user_id_foreign');
		});

		Schema::table('ratings', function (Blueprint $table) {
			$table->dropForeign('ratings_user_id_foreign');
			$table->dropForeign('ratings_manga_id_foreign');
		});

		Schema::table('category_manga', function (Blueprint $table) {
			$table->dropForeign('category_manga_manga_id_foreign');
			$table->dropForeign('category_manga_category_id_foreign');
		});

		Schema::table('mangas', function (Blueprint $table) {
			$table->dropForeign('mangas_user_id_foreign');
		});

		Schema::dropIfExists('favorites');
		Schema::dropIfExists('commentable');
		Schema::dropIfExists('comments');
		Schema::dropIfExists('ratings');
		Schema::dropIfExists('category_manga');
		Schema::dropIfExists('mangas');
		Schema::dropIfExists('categories');
	}
}
