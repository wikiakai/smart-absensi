<?php

namespace App\Filament\Resources\Absensis\Pages;

use App\Filament\Resources\Absensis\AbsensiResource;
use Filament\Resources\Pages\Page;
use App\Models\Pegawai;
use App\Models\Absensi;
use Filament\Forms\Form;
use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Request;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\Hidden;

class InputAbsensi extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = AbsensiResource::class;

    protected string $view = 'filament.resources.absensis.pages.input-absensi';

    protected static ?string $title = 'Form Input Absensi Kerja';

    public ?array $data = [];

    public function mount(): void
    {
        // 1. Tangkap tanggal dari URL (?tanggal=YYYY-MM-DD)
        $tanggalDipilih = Request::query('tanggal', now()->format('Y-m-d'));

        // 2. Ambil semua pegawai untuk di-looping ke dalam Repeater
        $daftarPegawai = Pegawai::all();

        $items = [];
        foreach ($daftarPegawai as $pegawai) {
            $items[] = [
                'pegawai_id'   => $pegawai->id,
                'nama_pegawai' => $pegawai->nama,
                'nip_pegawai' => $pegawai->nip,

                'jam_masuk'    => null,
                'jam_siang'    => null,
                'jam_pulang'   => null,
                'keterangan'   => '',
            ];
        }

        // 3. Set data awal ke Form
        $this->form->fill([
            'tanggal'      => $tanggalDipilih,
            'absensi_list' => $items,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Field tanggal dibuat disabled/readonly karena sudah dikunci dari halaman depan
                DatePicker::make('tanggal')
                    ->label('Tanggal Yang Sedang Diinput')
                    ->disabled()
                    ->dehydrated() // Tetap dikirim saat form di-submit
                    ->native(false),

                Repeater::make('absensi_list')
                    ->label('Daftar Baris Pegawai')
                    ->schema([
                        Hidden::make('pegawai_id'),
                        TextInput::make('nama_pegawai')
                            ->label('Nama Pegawai')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpan(2),
                        TextInput::make('nip_pegawai')
                            ->label('NIP')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpan(1),

                        TimePicker::make('jam_masuk')
                            ->label('Pagi')
                            ->native(false)      // 👈 Mematikan input bawaan browser
                            ->displayFormat('H:i') // 👈 Memaksa visual di layar jadi 24 Jam (Jam:Menit)
                            ->format('H:i')       // 👈 Format data saat dikirim ke database
                            ->lazy()
                            ->columnSpan(1),

                        TimePicker::make('jam_siang')
                            ->label('Siang')
                            ->native(false)      // 👈 Mematikan input bawaan browser
                            ->displayFormat('H:i') // 👈 Memaksa visual di layar jadi 24 Jam (Jam:Menit)
                            ->format('H:i')
                            ->lazy()
                            ->columnSpan(1),

                        TimePicker::make('jam_pulang')
                            ->label('Sore')
                            ->native(false)      // 👈 Mematikan input bawaan browser
                            ->displayFormat('H:i') // 👈 Memaksa visual di layar jadi 24 Jam (Jam:Menit)
                            ->format('H:i')
                            ->lazy()
                            ->columnSpan(1),
                    ])
                    ->columns(6)
                    ->addable(false) // Menghilangkan tombol "tambah baris"
                    ->deletable(false) // Menghilangkan tombol hapus baris
                    ->reorderable(false),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Absensi Hari Ini')
                ->color('primary')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $input = $this->form->getState();
        $tanggal = $input['tanggal'];

        foreach ($input['absensi_list'] as $row) {
            // Cek pengaman: Pastikan key pegawai_id benar-benar ada sebelum insert
            if (!isset($row['pegawai_id'])) {
                continue;
            }

            Absensi::create([
                'pegawai_id' => $row['pegawai_id'],
                'tanggal'    => $tanggal,
                'jam_masuk'  => $row['jam_masuk'],
                'jam_siang'  => $row['jam_siang'],
                'jam_pulang' => $row['jam_pulang'],
                // 'keterangan' => $row['keterangan'],
            ]);
        }

        Notification::make()
            ->title('Absensi Berhasil Disimpan!')
            ->success()
            ->send();

        $urlIndex = AbsensiResource::getUrl('index');

        return;
    }

    protected function getRedirectUrl(): string
    {
        return AbsensiResource::getUrl('index');
    }
}
