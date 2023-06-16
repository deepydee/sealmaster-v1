<?php

namespace App\Http\Livewire;

use App\Models\Callback;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\{ActionButton, WithExport};
use PowerComponents\LivewirePowerGrid\Filters\Filter;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridColumns};

final class MessagesTable extends PowerGridComponent
{
    use ActionButton;
    use WithExport;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\Callback>
     */
    public function datasource(): Builder
    {
        return Callback::query();
    }

    public function header(): array
    {
        return [
            Button::add('bulk-delete')
                ->caption(__('Множественное удаление (<span x-text="window.pgBulkActions.count(\'' . $this->tableName . '\')"></span>)'))
                ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->emit('bulkDeleteMessagesTable', []),
        ];
    }


    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(), [
                 'bulkDeleteMessagesTable',
                 'delete',
                 'deleteSelected',
                 'deleteConfirm',
                 'deleteSingleItem',
                 'readMessage',
                 'readConfirm',
                 'makeRead',
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('phone')
            ->addColumn('name')
            ->addColumn('message', fn (Callback $model) => Str::words(e($model->message), 8))
            ->addColumn('status_formatted', fn (Callback $model) => $model->is_read === 0 ? 'Не прочитано' : 'Прочитано')
            ->addColumn('created_at_formatted', fn (Callback $model) => Carbon::parse($model->created_at)->format('d.m.Y H:i'));
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('#', 'id'),
            Column::make('Телефон', 'phone')
                ->sortable()
                ->searchable(),

            Column::make('Имя', 'name')
                ->sortable()
                ->searchable(),

            // Column::make('Сообщение', 'message'),

            Column::make('Статус', 'status_formatted', 'status')
                ->sortable()
                ->bodyAttribute('text-sm font-medium text-cyan-800'),

            Column::make('Создано', 'created_at_formatted', 'created_at')
                ->sortable(),

        ];
    }

    /**
     * PowerGrid Filters.
     *
     * @return array<int, Filter>
     */
    public function filters(): array
    {
        return [
            Filter::inputText('phone')->operators(['contains']),
            Filter::inputText('name')->operators(['contains']),
            Filter::datepicker('created_at'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid Callback Action Buttons.
     *
     * @return array<int, Button>
     */


    public function actions(): array
    {
        return [
            Button::add('new-modal')
                ->caption('Читать')
                ->tooltip('Читать сообщение')
                ->class('bg-blue-300 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->emit('readMessage', ['id' => 'id']),

            Button::make('destroy', 'Delete')
                ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->caption('Удалить')
                ->tooltip('Удалить сообщение')
                ->target('_self')
                ->emit('deleteSingleItem', ['id' => 'id']
                ),
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid Callback Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($callback) => $callback->id === 1)
                ->hide(),
        ];
    }
    */

    public function bulkDeleteMessagesTable(): void
    {
        if (count($this->checkboxValues) == 0) {
            $this->dispatchBrowserEvent('notify', 'Нужно выбрать хотя бы один элемент!');

            return;
        }

        $this->deleteConfirm('deleteSelected');
    }

    public function deleteConfirm($method, $id = null)
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type'   => 'warning',
            'title'  => 'Вы уверены?',
            'text'   => '',
            'id'     => $id,
            'method' => $method,
        ]);
    }

    public function deleteSelected(): void
    {
        $messages = Callback::whereIn('id', $this->checkboxValues)->get();
        $messagesCount = count($messages);
        $messages->each->delete();

        $msg = "Удалено $messagesCount сообщений";
        $this->dispatchBrowserEvent('notify', $msg);
    }

    public function deleteSingleItem($id = null)
    {
        $this->deleteConfirm('delete', $id);
    }

    public function delete(Callback $message)
    {
        $message->delete();

        $msg = "Сообщение '{$message->name}' успешно удалено";
        $this->dispatchBrowserEvent('notify', $msg);
    }

    public function readMessage($id = null)
    {
        $message = Callback::findOrFail($id)->first();

        $this->readConfirm(
            $message->phone,
            $message->name,
            $id,
            $message->message,
        );
    }

    public function readConfirm($phone, $name, $id = null, $text = '')
    {
        $name = $name ?? 'Аноним';

        $message = $text
            ? 'Сообщение от '.$name." ($phone)"
            : "$name (<a href='tel:" .$phone. "'>$phone</a>) просит перезвонить";

        $this->dispatchBrowserEvent('swal:info', [
            'type'   => 'info',
            'title'  => $message,
            'text'   => $text,
            'id'     => $id,
            'method' => 'makeRead',
        ]);
    }

    public function makeRead(Callback $message)
    {
        $message->is_read = true;
        $message->save();
    }
}
