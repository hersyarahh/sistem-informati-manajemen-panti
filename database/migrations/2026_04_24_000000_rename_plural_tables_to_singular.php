<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->dropForeignIfExists('kehadirans', ['kegiatan_id']);
        $this->dropForeignIfExists('kehadirans', ['lansia_id']);
        $this->dropForeignIfExists('riwayat_kesehatans', ['lansia_id']);
        $this->dropForeignIfExists('terminasi_lansias', ['lansia_id']);
        $this->dropForeignIfExists('karyawan_lansia', ['lansia_id']);

        $this->renameTableIfExists('kegiatans', 'kegiatan');
        $this->renameTableIfExists('kehadirans', 'kehadiran');
        $this->renameTableIfExists('lansias', 'lansia');
        $this->renameTableIfExists('pekerja_sosials', 'pekerja_sosial');
        $this->renameTableIfExists('riwayat_kesehatans', 'riwayat_kesehatan');
        $this->renameTableIfExists('terminasi_lansias', 'terminasi_lansia');

        $this->addForeignIfPossible('kehadiran', function (Blueprint $table) {
            $table->foreign('kegiatan_id')->references('id')->on('kegiatan')->cascadeOnDelete();
        });
        $this->addForeignIfPossible('kehadiran', function (Blueprint $table) {
            $table->foreign('lansia_id')->references('id')->on('lansia')->cascadeOnDelete();
        });
        $this->addForeignIfPossible('riwayat_kesehatan', function (Blueprint $table) {
            $table->foreign('lansia_id')->references('id')->on('lansia')->onDelete('cascade');
        });
        $this->addForeignIfPossible('terminasi_lansia', function (Blueprint $table) {
            $table->foreign('lansia_id')->references('id')->on('lansia')->cascadeOnDelete();
        });
        $this->addForeignIfPossible('karyawan_lansia', function (Blueprint $table) {
            $table->foreign('lansia_id')->references('id')->on('lansia')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        $this->dropForeignIfExists('kehadiran', ['kegiatan_id']);
        $this->dropForeignIfExists('kehadiran', ['lansia_id']);
        $this->dropForeignIfExists('riwayat_kesehatan', ['lansia_id']);
        $this->dropForeignIfExists('terminasi_lansia', ['lansia_id']);
        $this->dropForeignIfExists('karyawan_lansia', ['lansia_id']);

        $this->renameTableIfExists('kegiatan', 'kegiatans');
        $this->renameTableIfExists('kehadiran', 'kehadirans');
        $this->renameTableIfExists('lansia', 'lansias');
        $this->renameTableIfExists('pekerja_sosial', 'pekerja_sosials');
        $this->renameTableIfExists('riwayat_kesehatan', 'riwayat_kesehatans');
        $this->renameTableIfExists('terminasi_lansia', 'terminasi_lansias');

        $this->addForeignIfPossible('kehadirans', function (Blueprint $table) {
            $table->foreign('kegiatan_id')->references('id')->on('kegiatans')->cascadeOnDelete();
        });
        $this->addForeignIfPossible('kehadirans', function (Blueprint $table) {
            $table->foreign('lansia_id')->references('id')->on('lansias')->cascadeOnDelete();
        });
        $this->addForeignIfPossible('riwayat_kesehatans', function (Blueprint $table) {
            $table->foreign('lansia_id')->references('id')->on('lansias')->onDelete('cascade');
        });
        $this->addForeignIfPossible('terminasi_lansias', function (Blueprint $table) {
            $table->foreign('lansia_id')->references('id')->on('lansias')->cascadeOnDelete();
        });
        $this->addForeignIfPossible('karyawan_lansia', function (Blueprint $table) {
            $table->foreign('lansia_id')->references('id')->on('lansias')->onDelete('cascade');
        });
    }

    private function renameTableIfExists(string $from, string $to): void
    {
        if (Schema::hasTable($from) && !Schema::hasTable($to)) {
            Schema::rename($from, $to);
        }
    }

    private function dropForeignIfExists(string $tableName, array $columns): void
    {
        if (!Schema::hasTable($tableName)) {
            return;
        }

        try {
            Schema::table($tableName, function (Blueprint $table) use ($columns) {
                $table->dropForeign($columns);
            });
        } catch (\Throwable $e) {
            // Ignore if the foreign key does not exist in this environment.
        }
    }

    private function addForeignIfPossible(string $tableName, \Closure $callback): void
    {
        if (!Schema::hasTable($tableName)) {
            return;
        }

        try {
            Schema::table($tableName, $callback);
        } catch (\Throwable $e) {
            // Ignore duplicate/invalid foreign key creation in mixed environments.
        }
    }
};
