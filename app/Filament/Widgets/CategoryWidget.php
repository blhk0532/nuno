<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use SolutionForest\FilamentTree\Widgets\Tree;

class CategoryWidget extends Tree
{
    protected static string $model = Category::class;

    protected static int $maxDepth = 2;

    protected ?string $treeTitle = 'CategoryWidget';

    protected bool $enableTreeTitle = true;

    protected function getFormSchema(): array
    {
        return [
            //
        ];
    }

    protected function getViewFormSchema(): array
    {
        return [
            // INFOLIST, CAN DELETE
        ];
    }

    protected function getTreeToolbarActions(): array
    {
        return [
            \SolutionForest\FilamentTree\Actions\CreateAction::make(),
        ];
    }

    // CUSTOMIZE ICON OF EACH RECORD, CAN DELETE
    // public function getTreeRecordIcon(?\Illuminate\Database\Eloquent\Model $record = null): ?string
    // {
    //     return null;
    // }

    // CUSTOMIZE ACTION OF EACH RECORD, CAN DELETE
    // protected function getTreeActions(): array
    // {
    //     return [
    //         Action::make('helloWorld')
    //             ->action(function () {
    //                 Notification::make()->success()->title('Hello World')->send();
    //             }),
    //         // ViewAction::make(),
    //         // EditAction::make(),
    //         ActionGroup::make([
    //
    //             ViewAction::make(),
    //             EditAction::make(),
    //         ]),
    //         DeleteAction::make(),
    //     ];
    // }
    // OR OVERRIDE FOLLOWING METHODS
    // protected function hasDeleteAction(): bool
    // {
    //    return true;
    // }
    // protected function hasEditAction(): bool
    // {
    //    return true;
    // }
    // protected function hasViewAction(): bool
    // {
    //    return true;
    // }
}
