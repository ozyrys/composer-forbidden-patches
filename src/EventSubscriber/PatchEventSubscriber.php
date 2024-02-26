<?php

namespace Ozyrys\ForbiddenPatches\Composer\EventSubscriber;

use Composer\Composer;
use Composer\IO\IOInterface;
use cweagans\Composer\ConfigurablePlugin;
use cweagans\Composer\Event\PatchEvent;
use cweagans\Composer\Event\PatchEvents;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Plugin\PluginInterface;
use Exception;

/**
 * Class CustomModuleEventSubscriber.
 */
class PatchEventSubscriber implements PluginInterface, EventSubscriberInterface {

  use ConfigurablePlugin;

  protected $composer;
  protected $io;

  protected const FORBIDDEN_PATCHES = [
    '39d4741d584818e20a9defb10a4b8e43bc6cce14090e1171a11fcdb6450d9b36',
  ];

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array
  {
    return [
      PatchEvents::PRE_PATCH_APPLY => ['onPrePatchApply', 10],
    ];
  }

  /**
   * Handles the PRE_PATCH_APPLY event.
   */
  public function onPrePatchApply(PatchEvent $event) {
    if ($this->getConfig('enable-forbidden-patches')) {
      $patch = $event->getPatch();
      //$serial = $patch->jsonSerialize();
      //$dump = var_export($serial, TRUE);
      //$this->io->write("  - QA EXTENSION Patch <info>{$dump}</info>");
      if (in_array($patch->sha256, self::FORBIDDEN_PATCHES)) {
        $e = new Exception("Frobidden patch: {$patch->url} to {$patch->package}");
        throw $e;
      }
      //$this->io->write("  - QA EXTENSION Patch <info>{$patch->localPath}</info>");
    }
  }

  public function activate(Composer $composer, IOInterface $io)
  {
    $this->composer = $composer;
    $this->io = $io;

    $this->configuration = [
      'enable-forbidden-patches' => [
        'type' => 'bool',
        'default' => false,
      ],
    ];
    $this->configure($composer->getPackage()->getExtra(), 'ozyrys-patch-event-subscriber');
  }

  public function deactivate(Composer $composer, IOInterface $io)
  {
    // TODO: Implement deactivate() method.
  }

  public function uninstall(Composer $composer, IOInterface $io)
  {
    // TODO: Implement uninstall() method.
  }
}
