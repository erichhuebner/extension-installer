<?php

namespace Hubzero;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class HubzeroInstaller extends LibraryInstaller
{
	/**
	 * {@inheritDoc}
	 */
	public function getInstallPath(PackageInterface $package)
	{
		switch ($package->getType())
		{
			case "hubzero-component":
				$directory = "components";
				$prefix = "com_";
				break;
			case "hubzero-plugin":
				$directory = "plugins";
				$prefix = "plg_";
				break;
			case "hubzero-module":
				$directory = "modules";
				$prefix = "mod_";
				break;
			case "hubzero-template":
				$directory = "templates";
				$prefix = "tmp_";
				break;
		}
		// Get the composer package name (returns in vendor/package format)
		$name = $package->getPrettyName();

		// Assume that the package name is the component name
		$pieces = explode("/", $name);
		$packagename = end($pieces);
		
		// Strip the prefix
		if (substr($packagename, 0, strlen($prefix)) == $prefix)
		{
			$packagename = substr($packagename, strlen($prefix), strlen($packagename));
		}
		return $directory . "/" . $packagename;
	}

	/**
	 * {@inheritDoc}
	 */
	public function supports($packageType)
	{
		$supportedTypes = ["hubzero-component", "hubzero-plugin", 
							"hubzero-module", "hubzero-template"];
		return in_array($packageType, $supportedTypes);
	}
}
