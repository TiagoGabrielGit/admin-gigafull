<?php


namespace TelegramBot\Entities;

use TelegramBot\Entity;

/**
 * Class Sticker
 *
 * @link https://core.telegram.org/bots/api#sticker
 *
 * @method string       getFileId()       Identifier for this file, which can be used to download or reuse the file
 * @method string       getFileUniqueId() Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @method int          getWidth()        Sticker width
 * @method int          getHeight()       Sticker height
 * @method bool         getIsAnimated()   True, if the sticker is animated
 * @method PhotoSize    getThumb()        Optional. Sticker thumbnail in .webp or .jpg format
 * @method string       getEmoji()        Optional. Emoji associated with the sticker
 * @method string       getSetName()      Optional. Name of the sticker set to which the sticker belongs
 * @method MaskPosition getMaskPosition() Optional. For mask stickers, the position where the mask should be placed
 * @method int          getFileSize()     Optional. File size
 */
class Sticker extends Entity
{

    /**
     * {@inheritdoc}
     */
    protected function subEntities(): array
    {
        return [
            'thumb' => PhotoSize::class,
            'mask_position' => MaskPosition::class,
        ];
    }

}
