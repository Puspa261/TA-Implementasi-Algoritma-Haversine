    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create('surat_tugas', function (Blueprint $table) {
                $table->id();
                $table->string('nosurat');
                $table->date('date');
                $table->time('started_at');
                $table->time('finished_at');
                $table->string('location')->nullable();
                $table->string('tikum')->nullable();
                // $table->foreignId('id_pegawai')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
                $table->string('id_pegawai');
                $table->date('tanggal_pembuatan');
                // $table->string('latitude');
                // $table->string('longitude');
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('surat_tugas');
        }
    };
