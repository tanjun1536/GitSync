package com.gang.comms;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.util.zip.ZipEntry;
import java.util.zip.ZipOutputStream;

public class ZipHelper {
	public static void main(String[] args) throws IOException {
		ZipHelper.doZipFolder("C:\\Users\\tanjun1536\\Desktop\\Hohsin", "C:\\Users\\tanjun1536\\Desktop\\FUCK.zip");
	}

	private static byte buffer[] = new byte[1024];

	public static boolean doZipFolder(String folder, String outFileName) throws IOException {
		File outFile = new File(outFileName);
		if (outFile.exists())
			outFile.delete();
		outFile.createNewFile();
		ZipOutputStream zos = new ZipOutputStream(new FileOutputStream(outFile));
		File dirtory = new File(folder);
		zipFolder(folder, zos, dirtory);
		zos.close();
		return true;
	}
	public static byte[] doZipFolder(String folder) throws IOException {
		ByteArrayOutputStream bios=new ByteArrayOutputStream();
		ZipOutputStream zos = new ZipOutputStream(bios);
		File dirtory = new File(folder);
		zipFolder(folder, zos, dirtory);
		zos.close();
		bios.close();
		return bios.toByteArray();
	}
	private static String getEntryName(String baseDirPath, File file) {
		if (!baseDirPath.endsWith(File.separator)) {
			baseDirPath += File.separator;
		}
		String filePath = file.getAbsolutePath();
		// 对于目录，必须在entry名字后面加上"/"，表示它将以目录项存储。
		if (file.isDirectory()) {
			filePath += "/";
		}
		int index = filePath.indexOf(baseDirPath);
		return filePath.substring(index + baseDirPath.length());
	}

	private static void zipFolder(String basePath,ZipOutputStream zos,File dirtory) throws IOException
	{
		if(dirtory.isDirectory())
		{
			if(dirtory.getName().equals("articles")) return;
			if(dirtory.listFiles().length==0){
				zos.putNextEntry(new ZipEntry(getEntryName(basePath,dirtory))); 
				zos.closeEntry(); 
			}
			else
			{
				for(File f:dirtory.listFiles())
				{
					zipFolder(basePath,zos,f);
				}
			}
		}
		else
		{
			//跳过本目录的zip文件
			if(dirtory.getName().endsWith(".zip")) return;
			InputStream entry = new FileInputStream(dirtory); 
			zos.putNextEntry(new ZipEntry(getEntryName(basePath,dirtory))); 
			int readedBytes=0;
			while((readedBytes = entry.read(buffer))>0){ 
				zos.write(buffer , 0 ,readedBytes); 
			}
			zos.closeEntry();
		}
	}

}
