<?php

/**
 * KashflowReceiptAttachment
 * 
 * @property int $AttachmentID System-wide unique number for the receipt attachment.
 * @property int $ReceiptID System-wide unique number for the receipt.
 * @property string $ActualFilename The filename specified by the user.
 * @property string $AmazonFilename The unique filename.
 * @property Datetime $UploadDate The date the file was attached.
 * @property string $ContentType The file type.
 * @property string $Metaname The Metadata name for the file.
 * @property string $MetaValue The Metadata value for the file.
 * @property string $FileSize The size of the file in KB.
 * @property string $FileExtension The extension of the file.
 * @property string $FileURL The public URL of the file.
 */
class KashflowReceiptAttachment extends KashflowModel {
	
}